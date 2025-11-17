<?php
require_once 'config/config.php';
require_once 'auth.php';
checkSession();

$current_user = getCurrentUser();

// Check for session messages
$session_success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$session_error = isset($_SESSION['error']) ? $_SESSION['error'] : '';

// Clear session messages after displaying
if ($session_success) unset($_SESSION['success']);
if ($session_error) unset($_SESSION['error']);

// Pagination settings
$patients_per_page = 25;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $patients_per_page;

// Search and sort parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort_by = isset($_GET['sort']) && in_array($_GET['sort'], ['first_name', 'last_name', 'date_of_birth', 'city', 'created_at']) ? $_GET['sort'] : 'last_name';
$sort_order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

try {
    // Build the WHERE clause for search
    $where_clause = '';
    $params = [];
    
    if (!empty($search)) {
        $where_clause = " WHERE (first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR phone LIKE ? OR city LIKE ?)";
        $search_term = "%$search%";
        $params = [$search_term, $search_term, $search_term, $search_term, $search_term];
    }
    
    // Count total patients for pagination
    $count_sql = "SELECT COUNT(*) FROM patients" . $where_clause;
    $count_stmt = $pdo->prepare($count_sql);
    $count_stmt->execute($params);
    $total_patients = $count_stmt->fetchColumn();
    $total_pages = ceil($total_patients / $patients_per_page);
    
    // Get patients for current page
    $sql = "SELECT patient_id, first_name, last_name, date_of_birth, address, house_number, postcode, city, phone, email, created_at 
            FROM patients" . $where_clause . " 
            ORDER BY $sort_by $sort_order 
            LIMIT ? OFFSET ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge($params, [$patients_per_page, $offset]));
    $patients = $stmt->fetchAll();
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $error_message = "Er is een fout opgetreden bij het ophalen van patiëntgegevens.";
    $patients = [];
    $total_patients = 0;
    $total_pages = 0;
}

// Helper functions
function getSortLink($column, $current_sort, $current_order) {
    $new_order = ($current_sort === $column && $current_order === 'ASC') ? 'DESC' : 'ASC';
    $search_param = !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '';
    return "?sort=$column&order=$new_order$search_param";
}

function getSortIcon($column, $current_sort, $current_order) {
    if ($current_sort !== $column) return '↕️';
    return $current_order === 'ASC' ? '🔼' : '🔽';
}

include_once 'includes/header.php';
?>

<!-- Admin Panel Banner -->
<div class="admin-panel-banner">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="text-white">
            <h1 class="text-2xl font-bold">👥 Patiënten Dashboard</h1>
            <p class="text-blue-100">Welkom, <?php echo htmlspecialchars($current_user['username']); ?>! 
                <span class="text-white/80">(<?php echo htmlspecialchars($current_user['role']); ?>)</span>
            </p>
        </div>
        <div class="space-x-4">
            <a href="add_patient.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 transition-all duration-300">
                ➕ Nieuwe Patiënt
            </a>
            <a href="index.php" class="border border-white text-white px-4 py-2 rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                🏠 Terug naar Home
            </a>
            <a href="logout.php" class="border border-white text-white px-4 py-2 rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                🚪 Uitloggen
            </a>
        </div>
    </div>
</div>

<div class="container mx-auto px-6 py-12">
    <!-- Statistics Cards -->
    <section class="mb-12">
        <div class="grid md:grid-cols-4 gap-6">
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center mb-4">
                        <span class="text-white text-2xl">👥</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-2"><?php echo $total_patients; ?></h3>
                    <p class="text-gray-600">Totaal Patiënten</p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-4">
                        <span class="text-white text-2xl">📋</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-2"><?php echo count($patients); ?></h3>
                    <p class="text-gray-600">Huidige Pagina</p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-red-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mb-4">
                        <span class="text-white text-2xl">📄</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-2"><?php echo $total_pages; ?></h3>
                    <p class="text-gray-600">Totaal Pagina's</p>
                </div>
            </div>
            
            <div class="group relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-4">
                        <span class="text-white text-2xl">🔍</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-2"><?php echo !empty($search) ? 'Actief' : 'Alle'; ?></h3>
                    <p class="text-gray-600">Zoekfilter</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Session Messages -->
    <?php if ($session_success): ?>
        <div class="bg-gradient-to-r from-green-100 to-emerald-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-8 backdrop-blur-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <?php echo htmlspecialchars($session_success); ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($session_error): ?>
        <div class="bg-gradient-to-r from-red-100 to-pink-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-8 backdrop-blur-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <?php echo htmlspecialchars($session_error); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Search and Filter Section -->
    <section class="relative bg-white rounded-3xl p-8 shadow-xl overflow-hidden mb-8">
        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full blur-2xl opacity-50"></div>
        <div class="relative z-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <span class="mr-3">🔍</span> Zoeken & Filteren
            </h2>
            
            <form method="GET" action="" class="space-y-6">
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" 
                               name="search" 
                               placeholder="Zoek op naam, email, telefoon of plaats..." 
                               value="<?php echo htmlspecialchars($search); ?>"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all duration-300 hover:border-gray-300">
                    </div>
                    
                    <select name="sort" class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all duration-300 hover:border-gray-300">
                        <option value="last_name" <?php echo $sort_by === 'last_name' ? 'selected' : ''; ?>>📝 Sorteer op achternaam</option>
                        <option value="first_name" <?php echo $sort_by === 'first_name' ? 'selected' : ''; ?>>👤 Sorteer op voornaam</option>
                        <option value="date_of_birth" <?php echo $sort_by === 'date_of_birth' ? 'selected' : ''; ?>>🎂 Sorteer op geboortedatum</option>
                        <option value="city" <?php echo $sort_by === 'city' ? 'selected' : ''; ?>>🏘️ Sorteer op plaats</option>
                        <option value="created_at" <?php echo $sort_by === 'created_at' ? 'selected' : ''; ?>>📅 Sorteer op registratiedatum</option>
                    </select>
                </div>
                
                <div class="flex gap-4">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        🔍 Zoeken
                    </button>
                    
                    <?php if (!empty($search)): ?>
                        <a href="dashboard.php" class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                            ❌ Wissen
                        </a>
                    <?php endif; ?>
                </div>
                
                <input type="hidden" name="order" value="<?php echo htmlspecialchars($sort_order); ?>">
            </form>
        </div>
    </section>

    <!-- Results Info -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-4 mb-6">
        <p class="text-gray-700 font-medium">
            <?php if (!empty($search)): ?>
                🔍 Zoekresultaten voor "<strong><?php echo htmlspecialchars($search); ?></strong>": 
                <span class="text-blue-600 font-bold"><?php echo $total_patients; ?></span> patiënt(en) gevonden
            <?php else: ?>
                📊 Totaal <span class="text-blue-600 font-bold"><?php echo $total_patients; ?></span> patiënt(en)
            <?php endif; ?>
            
            <?php if ($total_pages > 1): ?>
                | 📄 Pagina <span class="text-purple-600 font-bold"><?php echo $current_page; ?></span> van <span class="text-purple-600 font-bold"><?php echo $total_pages; ?></span>
            <?php endif; ?>
        </p>
    </div>

    <!-- Patients Table -->
    <?php if (isset($error_message)): ?>
        <div class="bg-gradient-to-r from-red-100 to-pink-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
            <strong>❌ Fout:</strong> <?php echo $error_message; ?>
        </div>
    <?php elseif (empty($patients)): ?>
        <div class="relative rounded-3xl bg-gradient-to-br from-gray-100 to-gray-200 text-center p-12 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-400/10 to-purple-400/10"></div>
            <div class="relative z-10">
                <?php if (!empty($search)): ?>
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Geen patiënten gevonden</h3>
                    <p class="text-gray-600 mb-6">Geen patiënten gevonden voor de zoekterm "<strong><?php echo htmlspecialchars($search); ?></strong>"</p>
                    <a href="dashboard.php" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-full font-semibold hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        📊 Alle patiënten bekijken
                    </a>
                <?php else: ?>
                    <div class="text-6xl mb-4">👥</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Nog geen patiënten</h3>
                    <p class="text-gray-600 mb-6">Er zijn nog geen patiënten geregistreerd in het systeem.</p>
                    <a href="add_patient.php" class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-full font-semibold hover:from-green-700 hover:to-emerald-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        ➕ Voeg eerste patiënt toe
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Modern Table -->
        <div class="relative bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                <a href="<?php echo getSortLink('last_name', $sort_by, $sort_order); ?>" class="flex items-center space-x-2 hover:text-blue-600 transition-colors">
                                    <span>👤 Achternaam</span>
                                    <span><?php echo getSortIcon('last_name', $sort_by, $sort_order); ?></span>
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                <a href="<?php echo getSortLink('first_name', $sort_by, $sort_order); ?>" class="flex items-center space-x-2 hover:text-blue-600 transition-colors">
                                    <span>📝 Voornaam</span>
                                    <span><?php echo getSortIcon('first_name', $sort_by, $sort_order); ?></span>
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                <a href="<?php echo getSortLink('date_of_birth', $sort_by, $sort_order); ?>" class="flex items-center space-x-2 hover:text-blue-600 transition-colors">
                                    <span>🎂 Geboortedatum</span>
                                    <span><?php echo getSortIcon('date_of_birth', $sort_by, $sort_order); ?></span>
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">📞 Contact</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                <a href="<?php echo getSortLink('city', $sort_by, $sort_order); ?>" class="flex items-center space-x-2 hover:text-blue-600 transition-colors">
                                    <span>🏘️ Plaats</span>
                                    <span><?php echo getSortIcon('city', $sort_by, $sort_order); ?></span>
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                <a href="<?php echo getSortLink('created_at', $sort_by, $sort_order); ?>" class="flex items-center space-x-2 hover:text-blue-600 transition-colors">
                                    <span>📅 Geregistreerd</span>
                                    <span><?php echo getSortIcon('created_at', $sort_by, $sort_order); ?></span>
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">⚡ Acties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($patients as $index => $patient): ?>
                            <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 <?php echo $index % 2 === 0 ? 'bg-white' : 'bg-gray-50'; ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($patient['last_name']); ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900"><?php echo htmlspecialchars($patient['first_name']); ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">
                                        <?php 
                                        if ($patient['date_of_birth']) {
                                            $dob = new DateTime($patient['date_of_birth']);
                                            $today = new DateTime();
                                            $age = $today->diff($dob)->y;
                                            echo $dob->format('d-m-Y') . " <span class='text-blue-600 font-medium'>($age jr)</span>";
                                        } else {
                                            echo '<span class="text-gray-400">-</span>';
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm space-y-1">
                                        <?php if ($patient['phone']): ?>
                                            <div class="text-gray-900">📞 <?php echo htmlspecialchars($patient['phone']); ?></div>
                                        <?php endif; ?>
                                        <?php if ($patient['email']): ?>
                                            <div class="text-gray-600 truncate max-w-32">📧 <?php echo htmlspecialchars($patient['email']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900">
                                        <?php 
                                        if ($patient['city']) {
                                            echo '🏘️ ' . htmlspecialchars($patient['city']);
                                            if ($patient['postcode']) {
                                                echo ' <span class="text-gray-500">(' . htmlspecialchars($patient['postcode']) . ')</span>';
                                            }
                                        } else {
                                            echo '<span class="text-gray-400">-</span>';
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">
                                        <?php 
                                        if ($patient['created_at']) {
                                            echo '📅 ' . date('d-m-Y', strtotime($patient['created_at']));
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="patient_notes.php?id=<?php echo $patient['patient_id']; ?>" 
                                           class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 py-2 rounded-lg text-xs font-semibold hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-300 shadow-sm" 
                                           title="Notities bekijken">
                                            📝
                                        </a>
                                        <a href="edit_patient.php?id=<?php echo $patient['patient_id']; ?>" 
                                           class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-3 py-2 rounded-lg text-xs font-semibold hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-300 shadow-sm" 
                                           title="Bewerken">
                                            ✏️
                                        </a>
                                        <a href="delete_patient.php?id=<?php echo $patient['patient_id']; ?>" 
                                           class="bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-2 rounded-lg text-xs font-semibold hover:from-red-600 hover:to-red-700 transform hover:scale-105 transition-all duration-300 shadow-sm" 
                                           title="Verwijderen"
                                           onclick="return confirm('Weet u zeker dat u deze patiënt wilt verwijderen?')">
                                            🗑️
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modern Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="flex justify-center items-center space-x-4 mt-8">
                <?php
                $search_param = !empty($search) ? '&search=' . urlencode($search) : '';
                $sort_param = "&sort=$sort_by&order=$sort_order";
                ?>
                
                <?php if ($current_page > 1): ?>
                    <a href="?page=1<?php echo $search_param . $sort_param; ?>" 
                       class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        « Eerste
                    </a>
                    <a href="?page=<?php echo $current_page - 1; ?><?php echo $search_param . $sort_param; ?>" 
                       class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        ‹ Vorige
                    </a>
                <?php endif; ?>
                
                <div class="flex space-x-2">
                    <?php
                    $start = max(1, $current_page - 2);
                    $end = min($total_pages, $current_page + 2);
                    
                    for ($i = $start; $i <= $end; $i++):
                    ?>
                        <?php if ($i == $current_page): ?>
                            <span class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-lg font-bold shadow-lg">
                                <?php echo $i; ?>
                            </span>
                        <?php else: ?>
                            <a href="?page=<?php echo $i; ?><?php echo $search_param . $sort_param; ?>" 
                               class="bg-white border-2 border-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-50 hover:border-gray-400 transform hover:scale-105 transition-all duration-300">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                
                <?php if ($current_page < $total_pages): ?>
                    <a href="?page=<?php echo $current_page + 1; ?><?php echo $search_param . $sort_param; ?>" 
                       class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        Volgende ›
                    </a>
                    <a href="?page=<?php echo $total_pages; ?><?php echo $search_param . $sort_param; ?>" 
                       class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        Laatste »
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
.admin-panel-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 50;
}

@media (max-width: 768px) {
    .admin-panel-banner .container > div {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .admin-panel-banner .space-x-4 {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    table {
        font-size: 0.875rem;
    }
    
    .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .py-4 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
}
</style>

<?php include_once 'includes/footer.php'; ?>
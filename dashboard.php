<?php
require_once 'config/config.php';
require_once 'auth.php';
checkSession();

$current_user = getCurrentUser();
$pdo = getDbConnection();

// Check for session messages
$session_success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$session_error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
if ($session_success) unset($_SESSION['success']);
if ($session_error) unset($_SESSION['error']);

// View mode (cards or table) - default is table
$view_mode = isset($_GET['view']) ? $_GET['view'] : 'table';

// Per page setting
$per_page_options = [10, 25, 50, 100];
$per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 25;
if (!in_array($per_page, $per_page_options)) {
    $per_page = 25;
}
$patients_per_page = $per_page;

$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $patients_per_page;

// Search and sort
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'last_name';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'asc';

try {
    $where_clause = '';
    $params = [];
    
    if (!empty($search)) {
        $where_clause = " WHERE (first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR phone LIKE ? OR city LIKE ?)";
        $search_term = "%$search%";
        $params = [$search_term, $search_term, $search_term, $search_term, $search_term];
    }
    
    $count_sql = "SELECT COUNT(*) FROM patients" . $where_clause;
    $count_stmt = $pdo->prepare($count_sql);
    $count_stmt->execute($params);
    $total_patients = $count_stmt->fetchColumn();
    $total_pages = ceil($total_patients / $patients_per_page);
    
    $sql = "SELECT * FROM patients" . $where_clause . " ORDER BY $sort_by $sort_order LIMIT ? OFFSET ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge($params, [$patients_per_page, $offset]));
    $patients = $stmt->fetchAll();
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $patients = [];
    $total_patients = 0;
    $total_pages = 0;
}

require_once 'includes/header.php';
?>

<!-- Modern Sidebar Dashboard -->
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r border-gray-200 fixed h-full overflow-y-auto">
        <div class="p-6">
            <!-- User Profile -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                        <?php echo strtoupper(substr($current_user['username'], 0, 2)); ?>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800"><?php echo htmlspecialchars($current_user['username']); ?></h3>
                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($current_user['role']); ?></p>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl p-4 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm opacity-90">Totaal Patiënten</span>
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-black"><?php echo number_format($total_patients); ?></div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="mb-8">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Snelle Acties</h4>
                <div class="space-y-2">
                    <a href="add_patient.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-green-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">Nieuwe Patiënt</span>
                    </a>
                </div>
            </div>
            
            <!-- View Toggle -->
            <div class="mb-8">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Weergave</h4>
                <div class="grid grid-cols-2 gap-2">
                    <a href="?view=cards&per_page=<?php echo $per_page; ?>&sort=<?php echo $sort_by; ?>&order=<?php echo $sort_order; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>" 
                       class="flex flex-col items-center px-3 py-3 rounded-xl <?php echo $view_mode === 'cards' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600'; ?> transition-colors">
                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span class="text-xs font-medium">Kaarten</span>
                    </a>
                    <a href="?view=table&per_page=<?php echo $per_page; ?>&sort=<?php echo $sort_by; ?>&order=<?php echo $sort_order; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>" 
                       class="flex flex-col items-center px-3 py-3 rounded-xl <?php echo $view_mode === 'table' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600'; ?> transition-colors">
                        <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs font-medium">Tabel</span>
                    </a>
                </div>
            </div>
            
            <!-- Items Per Page -->
            <div class="mb-8">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Items per Pagina</h4>
                <div class="grid grid-cols-2 gap-2">
                    <?php foreach ([10, 25, 50, 100] as $option): ?>
                        <a href="?view=<?php echo $view_mode; ?>&per_page=<?php echo $option; ?>&sort=<?php echo $sort_by; ?>&order=<?php echo $sort_order; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>" 
                           class="flex items-center justify-center px-3 py-2 rounded-xl <?php echo $per_page === $option ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600'; ?> transition-colors font-medium text-sm">
                            <?php echo $option; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Sort Options -->
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Sorteren</h4>
                <div class="space-y-1">
                    <?php
                    $sort_options = [
                        'last_name' => ['icon' => '👤', 'label' => 'Achternaam'],
                        'first_name' => ['icon' => '✏️', 'label' => 'Voornaam'],
                        'date_of_birth' => ['icon' => '🎂', 'label' => 'Leeftijd'],
                        'city' => ['icon' => '🏘️', 'label' => 'Plaats'],
                        'created_at' => ['icon' => '📅', 'label' => 'Registratie']
                    ];
                    foreach ($sort_options as $key => $option):
                        $is_active = $sort_by === $key;
                        $new_order = $is_active && $sort_order === 'ASC' ? 'desc' : 'asc';
                    ?>
                        <a href="?sort=<?php echo $key; ?>&order=<?php echo $new_order; ?>&view=<?php echo $view_mode; ?>&per_page=<?php echo $per_page; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>" 
                           class="flex items-center justify-between px-3 py-2 rounded-lg <?php echo $is_active ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'; ?> transition-colors">
                            <span class="text-sm"><?php echo $option['icon']; ?> <?php echo $option['label']; ?></span>
                            <?php if ($is_active): ?>
                                <span class="text-xs"><?php echo $sort_order === 'ASC' ? '↑' : '↓'; ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 ml-72 p-8">
        <!-- Search Bar -->
        <div class="mb-6">
            <form method="GET" action="" class="flex items-center space-x-4">
                <div class="flex-1 relative">
                    <input type="text" 
                           name="search" 
                           placeholder="Zoek patiënten..."
                           value="<?php echo htmlspecialchars($search); ?>"
                           class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:outline-none transition-all text-lg">
                    <svg class="w-6 h-6 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="hidden" name="view" value="<?php echo $view_mode; ?>">
                <input type="hidden" name="per_page" value="<?php echo $per_page; ?>">
                <input type="hidden" name="sort" value="<?php echo $sort_by; ?>">
                <input type="hidden" name="order" value="<?php echo $sort_order; ?>">
                <button type="submit" class="px-6 py-4 bg-blue-600 text-white rounded-2xl font-semibold hover:bg-blue-700 transition-colors">Zoek</button>
                <?php if (!empty($search)): ?>
                    <a href="?view=<?php echo $view_mode; ?>&per_page=<?php echo $per_page; ?>&sort=<?php echo $sort_by; ?>&order=<?php echo $sort_order; ?>" class="px-6 py-4 bg-gray-200 text-gray-700 rounded-2xl font-semibold hover:bg-gray-300 transition-colors">Wis</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Messages -->
        <?php if ($session_success): ?>
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <span class="text-green-700"><?php echo htmlspecialchars($session_success); ?></span>
            </div>
        <?php endif; ?>
        <?php if ($session_error): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <span class="text-red-700"><?php echo htmlspecialchars($session_error); ?></span>
            </div>
        <?php endif; ?>

        <?php if (empty($patients)): ?>
            <div class="text-center py-20">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Geen patiënten gevonden</h3>
                <p class="text-gray-500 mb-6">Pas je zoekopdracht aan of voeg een nieuwe patiënt toe</p>
                <a href="add_patient.php" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700">Nieuwe Patiënt</a>
            </div>
        <?php elseif ($view_mode === 'cards'): ?>
            <!-- Cards View -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach ($patients as $patient): 
                    $age = null;
                    if ($patient['date_of_birth']) {
                        $dob = new DateTime($patient['date_of_birth']);
                        $age = $dob->diff(new DateTime())->y;
                    }
                ?>
                    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-blue-200">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold">
                                    <?php echo strtoupper(substr($patient['first_name'], 0, 1) . substr($patient['last_name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800"><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></h3>
                                    <?php if ($age): ?>
                                        <span class="text-sm text-gray-500"><?php echo $age; ?> jaar</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <?php if ($patient['email']): ?>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="truncate"><?php echo htmlspecialchars($patient['email']); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($patient['phone']): ?>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span><?php echo htmlspecialchars($patient['phone']); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($patient['city']): ?>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span><?php echo htmlspecialchars($patient['city']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex space-x-2 pt-4 border-t border-gray-100">
                            <a href="patient_notes.php?id=<?php echo $patient['patient_id']; ?>" class="flex-1 bg-blue-50 text-blue-600 px-4 py-2 rounded-xl text-center text-sm font-medium hover:bg-blue-100 transition-colors whitespace-nowrap">
                                Notities
                            </a>
                            <a href="edit_patient.php?id=<?php echo $patient['patient_id']; ?>" class="flex-1 bg-green-50 text-green-600 px-4 py-2 rounded-xl text-center text-sm font-medium hover:bg-green-100 transition-colors whitespace-nowrap">
                                Bewerk
                            </a>
                            <a href="delete_patient.php?id=<?php echo $patient['patient_id']; ?>" class="flex items-center justify-center bg-red-50 text-red-600 px-4 py-2 rounded-xl text-sm font-medium hover:bg-red-100 transition-colors whitespace-nowrap" onclick="return confirm('Weet je het zeker?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Table View -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase whitespace-nowrap">Naam</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase whitespace-nowrap">Leeftijd</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase whitespace-nowrap">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase whitespace-nowrap">Plaats</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase whitespace-nowrap w-72">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($patients as $patient): 
                                $age = null;
                                if ($patient['date_of_birth']) {
                                    $dob = new DateTime($patient['date_of_birth']);
                                    $age = $dob->diff(new DateTime())->y;
                                }
                            ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                <?php echo strtoupper(substr($patient['first_name'], 0, 1) . substr($patient['last_name'], 0, 1)); ?>
                                            </div>
                                            <span class="font-medium text-gray-800"><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap"><?php echo $age ? $age . ' jaar' : '-'; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <?php if ($patient['phone']): ?>
                                            <div class="whitespace-nowrap"><?php echo htmlspecialchars($patient['phone']); ?></div>
                                        <?php endif; ?>
                                        <?php if ($patient['email']): ?>
                                            <div class="text-xs text-gray-500 truncate max-w-xs"><?php echo htmlspecialchars($patient['email']); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap"><?php echo $patient['city'] ? htmlspecialchars($patient['city']) : '-'; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <a href="patient_notes.php?id=<?php echo $patient['patient_id']; ?>" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-medium hover:bg-blue-200 transition-colors whitespace-nowrap">Notities</a>
                                            <a href="edit_patient.php?id=<?php echo $patient['patient_id']; ?>" class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-medium hover:bg-green-200 transition-colors whitespace-nowrap">Bewerk</a>
                                            <a href="delete_patient.php?id=<?php echo $patient['patient_id']; ?>" class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium hover:bg-red-200 transition-colors whitespace-nowrap" onclick="return confirm('Weet je het zeker?')">Verwijder</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="flex justify-center items-center space-x-2 mt-8">
                <?php if ($current_page > 1): ?>
                    <a href="?page=<?php echo $current_page-1; ?>&view=<?php echo $view_mode; ?>&per_page=<?php echo $per_page; ?>&sort=<?php echo $sort_by; ?>&order=<?php echo $sort_order; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Vorige</a>
                <?php endif; ?>
                
                <span class="px-4 py-2 text-sm text-gray-600">Pagina <?php echo $current_page; ?> van <?php echo $total_pages; ?></span>
                
                <?php if ($current_page < $total_pages): ?>
                    <a href="?page=<?php echo $current_page+1; ?>&view=<?php echo $view_mode; ?>&per_page=<?php echo $per_page; ?>&sort=<?php echo $sort_by; ?>&order=<?php echo $sort_order; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Volgende</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>
</div>

<style>
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slideIn {
    animation: slideIn 0.3s ease-out;
}

/* Custom scrollbar for sidebar */
aside::-webkit-scrollbar {
    width: 6px;
}

aside::-webkit-scrollbar-track {
    background: #f1f1f1;
}

aside::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 3px;
}

aside::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}
</style>

<?php require_once 'includes/footer.php'; ?>


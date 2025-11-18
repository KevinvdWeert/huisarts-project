# How to Publish Wiki to GitHub

## The Problem
GitHub wikis are **separate Git repositories** from your main code repository. The `.github/wiki/` folder is just local storage - it doesn't automatically sync to GitHub.

## Solution: Two Options

### Option 1: Manual Upload (Easiest)

1. Go to your GitHub repo: https://github.com/KevinvdWeert/huisarts-project

2. Click the **"Wiki"** tab at the top

3. Click **"Create the first page"** button

4. For each wiki page:
   - Click **"New Page"**
   - Copy the page title from filename (e.g., "Installation-Guide" from `Installation-Guide.md`)
   - Copy the content from the `.github/wiki/` markdown file
   - Click **"Save Page"**

5. Wiki pages to create:
   - Home (from `Home.md`)
   - Installation-Guide (from `Installation-Guide.md`)
   - Patient-Management (from `Patient-Management.md`)
   - SVG-Rendering-Bug (from `SVG-Rendering-Bug.md`)
   - Database-Schema (from `Database-Schema.md`)
   - Architecture (from `Architecture.md`)

### Option 2: Git Clone Method (After Creating First Page)

Once you've created at least one page on GitHub:

```powershell
# 1. Navigate to wiki directory
cd ".github/wiki"

# 2. Clone the wiki repository
git clone https://github.com/KevinvdWeert/huisarts-project.wiki.git

# 3. Copy all markdown files
Copy-Item *.md huisarts-project.wiki/

# 4. Commit and push
cd huisarts-project.wiki
git add .
git commit -m "Add comprehensive wiki documentation"
git push origin master

# 5. Clean up
cd ../..
Remove-Item -Recurse -Force ".github/wiki/huisarts-project.wiki"
```

## Why This Happens

GitHub wikis are **NOT part of your main repository**. They are:
- Separate Git repositories (`.wiki.git` suffix)
- Only accessible after creating the first page via web interface
- Cannot be initialized from the main repo
- Have their own commit history

## Quick Start (Recommended)

**Do this now:**

1. Open: https://github.com/KevinvdWeert/huisarts-project/wiki

2. Click **"Create the first page"**

3. Title: `Home`

4. Content: Copy everything from `.github/wiki/Home.md`

5. Click **"Save Page"**

6. Then use Option 2 above to bulk upload the rest

## Verification

After publishing, check:
- https://github.com/KevinvdWeert/huisarts-project/wiki
- All pages appear in sidebar
- Links between pages work
- Formatting renders correctly

## Alternative: Keep in Main Repo

If you prefer to keep wiki docs in the main repository:

```powershell
# Move wiki files to docs folder
New-Item -ItemType Directory -Path "docs" -Force
Move-Item ".github/wiki/*.md" "docs/"
Remove-Item -Recurse ".github/wiki"

# Commit to main repo
git add docs/
git commit -m "Add documentation to main repository"
git push
```

Then users can access docs directly in your repo at `/docs/`.

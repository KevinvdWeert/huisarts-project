# Huisarts Project Wiki

This directory contains the complete documentation for the Huisarts Project medical practice management system.

## 📚 Documentation Overview

The wiki consists of 13 comprehensive pages totaling over 80,000 words of documentation, covering everything from installation to advanced development.

## 🗂️ Wiki Pages

### Getting Started
- **[Home.md](Home.md)** - Main wiki entry point with navigation
- **[Quick-Start.md](Quick-Start.md)** - Get running in minutes
- **[Installation-Guide.md](Installation-Guide.md)** - Detailed installation (Apache, Nginx, Docker)

### User Documentation
- **[User-Guide.md](User-Guide.md)** - Complete user manual
- **[Patient-Management.md](Patient-Management.md)** - Managing patient records
- **[Notes-System.md](Notes-System.md)** - Patient notes documentation

### Configuration & Technical
- **[Configuration-Guide.md](Configuration-Guide.md)** - All configuration options
- **[Database-Schema.md](Database-Schema.md)** - Complete database documentation
- **[Code-Structure.md](Code-Structure.md)** - Codebase architecture

### Security & Development
- **[Security-Guidelines.md](Security-Guidelines.md)** - Security best practices
- **[Development-Guide.md](Development-Guide.md)** - Contributing guidelines

### Support
- **[FAQ.md](FAQ.md)** - Frequently asked questions
- **[Troubleshooting.md](Troubleshooting.md)** - Common issues and solutions

## 📖 How to Use This Documentation

### For New Users
1. Start with [Quick-Start.md](Quick-Start.md) for fast setup
2. Read [User-Guide.md](User-Guide.md) to learn features
3. Check [FAQ.md](FAQ.md) for common questions

### For Administrators
1. Follow [Installation-Guide.md](Installation-Guide.md) for proper setup
2. Review [Security-Guidelines.md](Security-Guidelines.md) before production
3. Configure using [Configuration-Guide.md](Configuration-Guide.md)

### For Developers
1. Review [Code-Structure.md](Code-Structure.md) to understand architecture
2. Read [Development-Guide.md](Development-Guide.md) for contribution guidelines
3. Reference [Database-Schema.md](Database-Schema.md) for data structure

### For Troubleshooting
1. Check [FAQ.md](FAQ.md) first
2. Consult [Troubleshooting.md](Troubleshooting.md) for specific issues
3. Search within documentation for keywords

## 🌐 GitHub Wiki Integration

These markdown files can be used directly as a GitHub Wiki:

### Option 1: Direct Wiki Repository
```bash
# Clone the wiki repository
git clone https://github.com/KevinvdWeert/huisarts-project.wiki.git

# Copy wiki files
cp wiki/*.md huisarts-project.wiki/

# Commit and push
cd huisarts-project.wiki
git add .
git commit -m "Add comprehensive documentation"
git push
```

### Option 2: GitHub Wiki Web Interface
1. Go to repository's Wiki tab
2. Create new page for each .md file
3. Copy content from corresponding file
4. Save each page

### Option 3: Keep in Repository
These files work perfectly as repository documentation:
- Browse directly on GitHub
- Render as markdown
- Easy to maintain with version control

## 📊 Documentation Statistics

- **Total Pages**: 13
- **Total Word Count**: 80,000+
- **Code Examples**: 200+
- **Sections**: 150+
- **Cross-references**: 100+

## 🔍 Quick Reference

### Essential Commands

**Installation**:
```bash
git clone https://github.com/KevinvdWeert/huisarts-project.git
mysql -u root -p < database/huisarts.sql
# Edit config/config.php
```

**Development**:
```bash
git checkout -b feature/new-feature
# Make changes
git commit -m "Add: New feature"
git push origin feature/new-feature
```

**Backup**:
```bash
mysqldump -u username -p huisarts > backup.sql
tar -czf backup_$(date +%Y%m%d).tar.gz /var/www/html/huisarts-project
```

### Default Credentials
- **Admin**: username `admin`, password `password`
- **Doctor**: username `doctor`, password `password`

⚠️ **Change immediately after installation!**

## 🆘 Getting Help

1. Search documentation (Ctrl+F)
2. Check [FAQ.md](FAQ.md)
3. Review [Troubleshooting.md](Troubleshooting.md)
4. Create GitHub issue

## 📝 Contributing to Documentation

### Improving Documentation
1. Fork repository
2. Edit wiki/*.md files
3. Submit pull request
4. Follow markdown style guide

### Style Guidelines
- Use clear, concise language
- Include code examples
- Add cross-references
- Keep consistent formatting
- Test all code examples

### What to Document
- New features
- Configuration changes
- Known issues
- Best practices
- Common workflows

## 🔄 Keeping Documentation Updated

Documentation should be updated when:
- Adding new features
- Changing configuration options
- Fixing bugs that affect usage
- Discovering new best practices
- Receiving common support questions

## 📚 External Resources

- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [OWASP Security Guide](https://owasp.org/)

## 📄 License

This documentation is part of the Huisarts Project and follows the same license as the main repository.

## ✨ Features of This Documentation

- ✅ Comprehensive coverage
- ✅ Step-by-step guides
- ✅ Code examples
- ✅ Security focus
- ✅ Troubleshooting solutions
- ✅ Cross-referenced
- ✅ Search-friendly
- ✅ Mobile-readable
- ✅ Professional quality
- ✅ Regularly maintained

---

**Last Updated**: November 2024  
**Version**: 2.0  
**Status**: Complete

For the latest documentation, visit the [GitHub repository](https://github.com/KevinvdWeert/huisarts-project).

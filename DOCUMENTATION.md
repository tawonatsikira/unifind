# Unifind Documentation

## Overview

This documentation covers the complete Unifind university and program search system. Unifind is a web application designed to help students discover universities and academic programs in Zimbabwe.

## Documentation Structure

### 1. [README.md](README.md) - Main Overview
- Project description and features
- System architecture overview
- Quick start guide
- Usage instructions

### 2. [ARCHITECTURE.md](ARCHITECTURE.md) - Technical Architecture
- System design and components
- Data flow diagrams
- Class structure and relationships
- Search algorithm implementation
- Deployment considerations

### 3. [DEVELOPER_GUIDE.md](DEVELOPER_GUIDE.md) - Development Guide
- Setup and installation instructions
- Code structure overview
- Adding new universities and programs
- Customizing search algorithm
- Styling and theming
- API development
- Testing and debugging
- Deployment checklist

### 4. [DATA_STRUCTURE.md](DATA_STRUCTURE.md) - Data Structure
- Complete JSON schema documentation
- University data structure
- Program data structure
- Announcement system
- File organization
- Data relationships and validation
- Sample data exports

### 5. [API_REFERENCE.md](API_REFERENCE.md) - API Reference
- Search API endpoints
- University API endpoints
- Program API endpoints
- Response formats and examples
- Error handling
- Usage examples
- Best practices

### 6. [SEARCH_API_DOCS.md](SEARCH_API_DOCS.md) - Original API Documentation
- Original search API specification
- Request/response formats
- Match types and scoring
- Example requests

## Quick Links

### Essential Files
- **Main Entry**: `index.html`
- **Search Logic**: `search.php`, `SearchAlgorithm.php`
- **Data Handling**: `DBHandler.php`
- **Class Definitions**: `classes/` directory
- **Data Files**: `unis.json`, `programs2.json`

### Key Features Documentation
- **Search Algorithm**: See ARCHITECTURE.md#search-algorithm-implementation
- **Data Models**: See DATA_STRUCTURE.md
- **API Usage**: See API_REFERENCE.md
- **Development**: See DEVELOPER_GUIDE.md

## Getting Help

### Common Tasks
- **Adding a University**: DEVELOPER_GUIDE.md#adding-new-universities
- **Adding a Program**: DEVELOPER_GUIDE.md#adding-new-programs
- **Customizing Search**: DEVELOPER_GUIDE.md#customizing-search-algorithm
- **API Integration**: API_REFERENCE.md#usage-examples

### Troubleshooting
- Check error logs for PHP errors
- Validate JSON files for syntax errors
- Verify file permissions
- Test search functionality thoroughly

## Version Information

This documentation covers the current version of Unifind as found in the codebase. The system uses file-based JSON storage and PHP backend processing.

## Contributing

When making changes to the system:
1. Update relevant documentation
2. Test changes thoroughly
3. Follow coding standards
4. Maintain data consistency

## Support

For additional support or questions:
1. Refer to the detailed documentation files
2. Check existing examples in the codebase
3. Test with sample data before production use

---

*This documentation was generated based on the current Unifind codebase. Last updated: [Current Date]*

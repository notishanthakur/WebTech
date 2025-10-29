// Global variables
let currentDatabase = 'webtech_db';
let currentTable = 'students';

// Utility function to show status messages
function showStatus(message, type = 'info') {
    const statusDiv = document.getElementById('status');
    statusDiv.textContent = message;
    statusDiv.className = `status-message status-${type}`;
    statusDiv.style.display = 'block';
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        statusDiv.style.display = 'none';
    }, 5000);
}

// Utility function to clear form
function clearForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
    }
}

// Create Database
function createDatabase() {
    const dbName = document.getElementById('dbName').value.trim();
    
    if (!dbName) {
        showStatus('Please enter a database name', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'create_database');
    formData.append('db_name', dbName);
    
    fetch('api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showStatus(data.message, 'success');
            currentDatabase = dbName;
            // Clear the input after successful creation
            document.getElementById('dbName').value = '';
        } else {
            showStatus(data.message, 'error');
        }
    })
    .catch(error => {
        showStatus('Error: ' + error.message, 'error');
    });
}

// Create Table
function createTable() {
    const tableName = document.getElementById('tableName').value.trim();
    
    if (!tableName) {
        showStatus('Please enter a table name', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'create_table');
    formData.append('db_name', currentDatabase);
    formData.append('table_name', tableName);
    
    fetch('api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showStatus(data.message, 'success');
            currentTable = tableName;
            // Clear the input after successful creation
            document.getElementById('tableName').value = '';
        } else {
            showStatus(data.message, 'error');
        }
    })
    .catch(error => {
        showStatus('Error: ' + error.message, 'error');
    });
}

// Insert Record
function insertRecord() {
    const fname = document.getElementById('fname').value.trim();
    const lname = document.getElementById('lname').value.trim();
    const regni = document.getElementById('regni').value.trim();
    const sec = document.getElementById('sec').value.trim();
    const address = document.getElementById('address').value.trim();
    
    if (!fname || !lname || !regni || !sec) {
        showStatus('Please fill in all required fields (First Name, Last Name, Registration Number, Section)', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'insert_record');
    formData.append('db_name', currentDatabase);
    formData.append('table_name', currentTable);
    formData.append('fname', fname);
    formData.append('lname', lname);
    formData.append('regni', regni);
    formData.append('sec', sec);
    formData.append('address', address);
    
    fetch('api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showStatus(data.message, 'success');
            // Clear the form after successful insertion
            clearInsertForm();
        } else {
            showStatus(data.message, 'error');
        }
    })
    .catch(error => {
        showStatus('Error: ' + error.message, 'error');
    });
}

// Clear insert form
function clearInsertForm() {
    document.getElementById('fname').value = '';
    document.getElementById('lname').value = '';
    document.getElementById('regni').value = '';
    document.getElementById('sec').value = '';
    document.getElementById('address').value = '';
}

// Search Records
function searchRecords() {
    const searchId = document.getElementById('searchId').value.trim();
    const searchFname = document.getElementById('searchFname').value.trim();
    const searchLname = document.getElementById('searchLname').value.trim();
    
    if (!searchId && !searchFname && !searchLname) {
        showStatus('Please enter at least one search criteria', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'search_records');
    formData.append('db_name', currentDatabase);
    formData.append('table_name', currentTable);
    formData.append('search_id', searchId);
    formData.append('search_fname', searchFname);
    formData.append('search_lname', searchLname);
    
    fetch('api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displaySearchResults(data.records);
            showStatus(`Found ${data.count} record(s)`, 'success');
        } else {
            showStatus(data.message, 'error');
        }
    })
    .catch(error => {
        showStatus('Error: ' + error.message, 'error');
    });
}

// Display search results
function displaySearchResults(records) {
    const resultsDiv = document.getElementById('results');
    
    if (records.length === 0) {
        resultsDiv.innerHTML = '<div class="no-results">No records found matching your search criteria.</div>';
        return;
    }
    
    let html = '<table class="results-table">';
    html += '<thead><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Registration</th><th>Section</th><th>Address</th><th>Created</th></tr></thead>';
    html += '<tbody>';
    
    records.forEach(record => {
        html += '<tr>';
        html += `<td>${record.ID}</td>`;
        html += `<td>${record.FNAME}</td>`;
        html += `<td>${record.LNAME}</td>`;
        html += `<td>${record.REGNI}</td>`;
        html += `<td>${record.SEC}</td>`;
        html += `<td>${record.ADDRESS || 'N/A'}</td>`;
        html += `<td>${new Date(record.created_at).toLocaleString()}</td>`;
        html += '</tr>';
    });
    
    html += '</tbody></table>';
    resultsDiv.innerHTML = html;
}

// Clear search
function clearSearch() {
    document.getElementById('searchId').value = '';
    document.getElementById('searchFname').value = '';
    document.getElementById('searchLname').value = '';
    document.getElementById('results').innerHTML = '';
    showStatus('Search cleared', 'info');
}

// Add Enter key support for forms
document.addEventListener('DOMContentLoaded', function() {
    // Database name input
    document.getElementById('dbName').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            createDatabase();
        }
    });
    
    // Table name input
    document.getElementById('tableName').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            createTable();
        }
    });
    
    // Search inputs
    document.getElementById('searchId').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchRecords();
        }
    });
    
    document.getElementById('searchFname').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchRecords();
        }
    });
    
    document.getElementById('searchLname').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchRecords();
        }
    });
    
    // Show initial status
    showStatus('Database Management System Ready. Please create a database first.', 'info');
});


const API_BASE = 'http://localhost:8080/api';

const createTableHead = (headers) => {
  const thead = document.createElement('thead');
  const headerRow = document.createElement('tr');

  headers.forEach(header => {
    const th = document.createElement('th');
    th.textContent = header;
    headerRow.appendChild(th);
  });

  thead.appendChild(headerRow);
  return thead;
};

const createTableBody = (headers, users) => {
  const tbody = document.createElement('tbody');

  users.forEach(user => {
    const row = document.createElement('tr');

    headers.forEach(header => {
      const cell = document.createElement('td');
      cell.textContent = user[header];
      row.appendChild(cell);
    });

    tbody.appendChild(row);
  });
  
  return tbody;
};

const getUsersData = async () => {
  const url = API_BASE + '/users/getAll.php';

  try {
    const response = await fetch(url);
    const users = await response.json();
    return users;
  } catch (error) {
    console.log('Error:', error);
    throw error;
  }
};

const renderUsersTable = async () => {
  try {
    const users = await getUsersData();
    const table = document.getElementById('users');
      
    const headers = Object.keys(users[0]);
    const thead = createTableHead(headers);
    table.appendChild(thead);

    const tbody = createTableBody(headers, users);
    table.appendChild(tbody);
  } catch (error) {
    console.log('Error:', error);
  }
};

renderUsersTable();
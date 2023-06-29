const API_BASE = 'http://localhost:8080/api';

const createTableHead = (headers: string[]) => {
  const thead = document.createElement('thead');
  const headerRow = document.createElement('tr');

  headers.forEach(header => {
    const th = document.createElement('th');
    th.textContent = header;
    headerRow.appendChild(th);
  });
  
  // Empty for action button
  const th = document.createElement('th');
  headerRow.appendChild(th);

  thead.appendChild(headerRow);
  return thead;
};

const getDeleteButton = (userId: string) => {
  const button = document.createElement('button');
  button.textContent = 'Delete';
  const deleteButtonHandler = async () => {
    const url = API_BASE + '/users/deleteById.php';
    try {
      const response = await fetch(url, { 
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `userId=${userId}`,
      });
      //const data = await response.json();
      if (response.ok) {
        window.location.reload();
      }
    } catch (error) {
      console.log('Error:', error);
      throw error;
    }
  };
  button.addEventListener('click', deleteButtonHandler);
  return button;
};

const createTableBody = (headers: string[], users: Record<string, string>[]) => {
  const tbody = document.createElement('tbody');

  users.forEach(user => {
    const row = document.createElement('tr');

    headers.forEach(header => {
      const cell = document.createElement('td');
      cell.textContent = user[header];
      row.appendChild(cell);
    });

    const additionalCell = document.createElement('td');
    if (user['id']) {
      additionalCell.appendChild(getDeleteButton(user['id']));
    }
    row.appendChild(additionalCell);

    tbody.appendChild(row);
  });

  return tbody;
};

const getUsersData = async (): Promise<Record<string, string>[]> => {
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

const renderUsersTable = async (): Promise<void> => {
  try {
    const users = await getUsersData();
    const table = document.getElementById('users') as HTMLTableElement;

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

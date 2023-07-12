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
  button.textContent = 'Remove';
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

const convertToURLParams = (jsonObj: { [key: string]: any }) => {
  const params = [];
  
  for (const key in jsonObj) {
    if (jsonObj.hasOwnProperty(key)) {
      const value = jsonObj[key];
      params.push(`${encodeURIComponent(key)}=${encodeURIComponent(value)}`);
    }
  }
  
  return params.join('&');
};

const createList = (strings: string[]): HTMLUListElement => {
  const ul = document.createElement('ul');
  
  strings.forEach((str) => {
    const li = document.createElement('li');
    li.textContent = str;
    ul.appendChild(li);
  });
  
  return ul;
}

const displayErrors = (errors: { [fieldId: string]: string[] }) => {
  for (const fieldId in errors) {
    const fieldErrors = errors[fieldId];
    
    console.log(`Field with id="${fieldId}" has errors:`, fieldErrors);
    
    const ul = createList(fieldErrors);
    ul.style.color = 'red';
    const input = document.getElementById(fieldId);
    if (input) {
      input.parentElement?.appendChild(ul);
    }
  }
};

const submitHandler = async (e: SubmitEvent) => {
  e.preventDefault();

  const url = createNewUserForm.action;

  const formData = new FormData(createNewUserForm);

  // TODO(tim): repair the formData.entries() warning and remove below workaround
  //const data = Object.fromEntries(formData.entries());

  const data: { [key: string]: any } = {};
  formData.forEach((value, key) => {
    data[key] = value;
  });

  try {
    const response = await fetch(url, {
      method: 'POST',
      body: convertToURLParams(data),
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    });
    if (response.status === 201) {
      window.location.reload();
    } else {
      const data = await response.json();
      displayErrors(data.error);
    }
  } catch (error) {
    console.log('Error:', error);
    throw error;
  }

  // submit the request manually
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


const createNewUserForm = document.getElementById('createUser') as HTMLFormElement;
createNewUserForm.addEventListener('submit', submitHandler)

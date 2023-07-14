const API_BASE = 'http://localhost:8080/api';

interface Address {
  street: string;
  suite: string;
  city: string;
  zipcode: string;
}

interface Company {
  name: string;
  catchPhrase?: string;
  bs?: string;
}

interface User {
  id: number;
  name: string;
  username: string;
  email: string;
  phone: string;
  address: Address;
  company: Company;
  website?: string;
}

class TableRenderer {
  private headers: (keyof User)[];
  private users: User[];

  constructor(headers: (keyof User)[], users: User[]) {
    this.headers = headers;
    this.users = users;
  }

  private createTableHead(): HTMLTableSectionElement {
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');

    this.headers.forEach((header) => {
      const th = document.createElement('th');
      th.textContent = header;
      headerRow.appendChild(th);
    });

    const th = document.createElement('th');
    headerRow.appendChild(th);

    thead.appendChild(headerRow);
    return thead;
  }

  private getDeleteButton(userId: number): HTMLButtonElement {
    const button = document.createElement('button');
    button.textContent = 'Remove';

    const deleteButtonHandler = async () => {
      const url = `${API_BASE}/users/deleteById.php`;

      try {
        const response = await fetch(url, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `userId=${userId}`,
        });

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
  }

  private createTableBody(): HTMLTableSectionElement {
    const tbody = document.createElement('tbody');

    this.users.forEach((user) => {
      const row = document.createElement('tr');

      this.headers.forEach((header) => {
        const cell = document.createElement('td');

        if (header === 'address') {
          const address = user[header] as Address;
          cell.textContent = `${address.street}, ${address.zipcode} ${address.city}`;
        } else if (header === 'company') {
          const company = user[header] as Company;
          cell.textContent = company.name;
        } else {
          cell.textContent = String(user[header]);
        }

        row.appendChild(cell);
      });

      const additionalCell = document.createElement('td');
      if (user['id']) {
        additionalCell.appendChild(this.getDeleteButton(user['id']));
      }
      row.appendChild(additionalCell);

      tbody.appendChild(row);
    });

    return tbody;
  }

  public renderTable(): void {
    const table = document.getElementById('users') as HTMLTableElement;
    const thead = this.createTableHead();
    const tbody = this.createTableBody();

    table.appendChild(thead);
    table.appendChild(tbody);
  }
}

class UserForm {
  private formElement: HTMLFormElement;

  constructor(formId: string) {
    this.formElement = document.getElementById(formId) as HTMLFormElement;
    this.formElement.addEventListener('submit', this.submitHandler.bind(this));
  }

  private async submitHandler(e: Event): Promise<void> {
    e.preventDefault();

    const url = this.formElement.action;
    const formData = new FormData(this.formElement);
    const data: { [key: string]: any } = {};

    formData.forEach((value, key) => {
      data[key] = value;
    });

    try {
      const response = await fetch(url, {
        method: 'POST',
        body: this.convertToURLParams(data),
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      });

      if (response.status === 201) {
        window.location.reload();
      } else {
        const errorData = await response.json();
        this.displayErrors(errorData.error);
      }
    } catch (error) {
      console.log('Error:', error);
      throw error;
    }
  }

  private convertToURLParams(jsonObj: { [key: string]: any }): string {
    const params = [];

    for (const key in jsonObj) {
      if (jsonObj.hasOwnProperty(key)) {
        const value = jsonObj[key];
        params.push(`${encodeURIComponent(key)}=${encodeURIComponent(value)}`);
      }
    }

    return params.join('&');
  }

  private createList(strings: string[]): HTMLUListElement {
    const ul = document.createElement('ul');

    strings.forEach((str) => {
      const li = document.createElement('li');
      li.textContent = str;
      ul.appendChild(li);
    });

    return ul;
  }

  private displayErrors(errors: { [fieldId: string]: string[] }): void {
    for (const fieldId in errors) {
      const fieldErrors = errors[fieldId];

      console.log(`Field with id="${fieldId}" has errors:`, fieldErrors);

      const ul = this.createList(fieldErrors);
      ul.style.color = 'red';
      const input = document.getElementById(fieldId);

      if (input) {
        input.parentElement?.appendChild(ul);
      }
    }
  }
}

const getUsersData = async (): Promise<User[]> => {
  const url = `${API_BASE}/users/getAll.php`;

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
    const users: User[] = await getUsersData();
    const headers = Object.keys(users[0]) as (keyof User)[];
    const tableRenderer = new TableRenderer(headers, users);
    tableRenderer.renderTable();
  } catch (error) {
    console.log('Error:', error);
  }
};

const userForm = new UserForm('createUser');
renderUsersTable();

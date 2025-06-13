// Model
const Model = {
    async registerUser(data) {
        try {
            const response = await fetch('http://localhost:3000/backend/public/api/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            return await response.json();
        } catch (error) {
            console.error('Ошибка регистрации:', error);
            return { success: false, message: 'Ошибка сети' };
        }
    },

    async loginUser(data) {
        try {
            const response = await fetch('http://localhost:3000/backend/public/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            return await response.json();
        } catch (error) {
            console.error('Ошибка входа:', error);
            return { success: false, message: 'Ошибка сети' };
        }
    }
};

// View
const View = {
    showRegister() {
        document.getElementById('register-view').classList.remove('hidden');
        document.getElementById('login-view').classList.add('hidden');
        document.getElementById('register-error').classList.add('hidden');
        document.getElementById('login-error').classList.add('hidden');
    },

    showLogin() {
        document.getElementById('login-view').classList.remove('hidden');
        document.getElementById('register-view').classList.add('hidden');
        document.getElementById('register-error').classList.add('hidden');
        document.getElementById('login-error').classList.add('hidden');
    },

    showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
    },

    clearInputs(...inputIds) {
        inputIds.forEach(id => document.getElementById(id).value = '');
    }
};

// Controller
const Controller = {
    init() {
        document.getElementById('show-login').addEventListener('click', () => View.showLogin());
        document.getElementById('show-register').addEventListener('click', () => View.showRegister());

        document.getElementById('register-btn').addEventListener('click', async () => {
            const username = document.getElementById('reg-username').value;
            const email = document.getElementById('reg-email').value;
            const password = document.getElementById('reg-password').value;

            if (!username || !email || !password) {
                View.showError('register-error', 'All fields are required');
                return;
            }

            const response = await Model.registerUser({ username, email, password });
            if (response.success) {
                View.clearInputs('reg-username', 'reg-email', 'reg-password');
                View.showLogin();
            } else {
                View.showError('register-error', response.message);
            }
        });

        document.getElementById('login-btn').addEventListener('click', async () => {
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;

            if (!email || !password) {
                View.showError('login-error', 'All fields are required');
                return;
            }

            const response = await Model.loginUser({ email, password });
            if (response.success) {
                View.clearInputs('login-email', 'login-password');
                alert('Login successful!');
            } else {
                View.showError('login-error', response.message);
            }
        });

        View.showRegister();
    }
};

// Initialize the app
Controller.init();
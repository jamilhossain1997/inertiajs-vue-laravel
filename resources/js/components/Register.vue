<template>
  <!-- <div>
    <h2>Register</h2>
    <form @submit.prevent="register">
      <input type="text" v-model="name" placeholder="Name" /><br /><br />
      <input type="email" v-model="email" placeholder="Email" /><br /><br />
      <input type="password" v-model="password" placeholder="Password" /><br /><br />
      <input type="password" v-model="password_confirmation" placeholder="Confirm Password" /><br /><br />
      <button type="submit">Register</button>
    </form>
  </div> -->

  <div class="signup-container">
    <form @submit.prevent="register" class="signup-form">
      <h2>Create an Account</h2>

      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="username" v-model="form.username" placeholder="Enter your username" required>
        <small class="error-message">{{ errors.username }}</small>
      </div>

      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" v-model="form.email" placeholder="Enter your email" required>
        <small class="error-message">{{ errors.email }}</small>
      </div>

      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" v-model="form.password" placeholder="Enter your password" required>
        <small class="error-message">{{ errors.password }}</small>
      </div>

      <div class="input-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" v-model="form.confirmPassword" placeholder="Confirm your password"
          required>
        <small class="error-message">{{ errors.confirmPassword }}</small>
      </div>

      <button type="submit" class="submit-btn">Sign Up</button>

      <div class="login-link">
        <p>Already have an account? <a href="#">Login here</a></p>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    };
  },
  methods: {
    async register() {
      try {
        await axios.post('/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        });
        this.$router.push('/login');
      } catch (error) {
        console.error('Registration failed', error);
      }
    }
  }
};
</script>

<style scoped>
.signup-container {
  background-color: white;
  width: 400px;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.signup-form {
  display: flex;
  flex-direction: column;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.input-group {
  margin-bottom: 15px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 14px;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
  outline: none;
  border-color: #3498db;
}

button.submit-btn {
  padding: 10px;
  background-color: #3498db;
  border: none;
  border-radius: 5px;
  color: white;
  font-size: 16px;
  cursor: pointer;
}

button.submit-btn:hover {
  background-color: #2980b9;
}

.error-message {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}

.login-link {
  text-align: center;
  margin-top: 20px;
}

.login-link a {
  color: #3498db;
  text-decoration: none;
}

.login-link a:hover {
  text-decoration: underline;
}
</style>
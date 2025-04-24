<template>
  <div class="signup-container">
    <form @submit.prevent="submit" autocomplete="off" class="signup-form">
      <h2>Create an Account</h2>

      <div class="input-group">
        <label for="name">Username</label>
        <input type="text" id="name" v-model="form.name"  placeholder="Enter your username"  required />
        <small class="error-message" v-if="form.errors.name">{{ form.errors.name }}</small>
      </div>

      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" v-model="form.email"  placeholder="Enter your email" required />
        <small class="error-message" v-if="form.errors.email">{{ form.errors.email }}</small>
      </div>

      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" v-model="form.password"  placeholder="Enter your password" required />
        <small class="error-message" v-if="form.errors.password">{{ form.errors.password }}</small>
      </div>

      <div class="input-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" v-model="form.password_confirmation"  placeholder="Confirm your password" required />
        <small class="error-message" v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</small>
      </div>

      <button type="submit" class="submit-btn">Sign Up</button>

      <div class="login-link">
        <p>Already have an account? <a href="/login">Login here</a></p>
      </div>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

const submit = () => {
  form.post('/register')
}
</script>

<style scoped>
.signup-container {
  max-width: 400px;
  margin: auto;
  padding: 20px;
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

input[type="text"], input[type="email"], input[type="password"] {
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

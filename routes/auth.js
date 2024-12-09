const express = require('express');
const User = require('../models/User');
const auth = require('../middleware/auth');
const router = express.Router();

// Register
router.post('/register', async (req, res) => {
    try {
        const user = new User(req.body);
        await user.save();
        const token = await user.generateAuthToken();
        res.status(201).send({ 
            success: true,
            message: 'Registration successful! You can now login.',
            user, 
            token 
        });
    } catch (error) {
        let errorMessage = 'Registration failed. Please try again.';
        
        // Handle specific errors
        if (error.name === 'SequelizeUniqueConstraintError') {
            errorMessage = 'This email is already registered.';
        } else if (error.name === 'SequelizeValidationError') {
            errorMessage = error.errors[0].message;
        }
        
        res.status(400).send({ 
            success: false,
            message: errorMessage,
            error: error.message 
        });
    }
});

// Login
router.post('/login', async (req, res) => {
    try {
        const user = await User.findByCredentials(req.body.email, req.body.password);
        const token = await user.generateAuthToken();
        res.send({ user, token });
    } catch (error) {
        res.status(400).send({ error: 'Login failed! Check authentication credentials' });
    }
});

// Logout
router.post('/logout', auth, async (req, res) => {
    try {
        req.user.tokens = req.user.tokens.filter(token => token.token !== req.token);
        await req.user.save();
        res.send({ message: 'Logged out successfully' });
    } catch (error) {
        res.status(500).send(error);
    }
});

// Logout from all devices
router.post('/logoutAll', auth, async (req, res) => {
    try {
        req.user.tokens = [];
        await req.user.save();
        res.send({ message: 'Logged out from all devices successfully' });
    } catch (error) {
        res.status(500).send(error);
    }
});

// Get user profile
router.get('/profile', auth, async (req, res) => {
    res.send(req.user);
});

module.exports = router; 
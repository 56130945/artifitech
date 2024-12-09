const jwt = require('jsonwebtoken');
const User = require('../models/User');
const Token = require('../models/Token');

const auth = async (req, res, next) => {
    try {
        const token = req.header('Authorization').replace('Bearer ', '');
        const decoded = jwt.verify(token, process.env.JWT_SECRET);
        
        const tokenRecord = await Token.findOne({
            where: {
                token: token,
                userId: decoded.id
            }
        });

        if (!tokenRecord) {
            throw new Error();
        }

        const user = await User.findByPk(decoded.id);
        if (!user) {
            throw new Error();
        }

        req.token = token;
        req.user = user;
        next();
    } catch (error) {
        res.status(401).send({ error: 'Please authenticate.' });
    }
};

module.exports = auth; 
class ParticleNetwork {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.particleCount = 100;
        this.particles = [];
        this.maxDistance = 100;
        this.mousePosition = { x: 0, y: 0 };
        this.colors = [
            'rgba(220, 53, 69, 0.5)',  // Red
            'rgba(13, 110, 253, 0.5)'  // Blue
        ];

        this.resize();
        this.initParticles();
        this.bindEvents();
        this.animate();
    }

    resize() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }

    initParticles() {
        for (let i = 0; i < this.particleCount; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                vx: Math.random() * 2 - 1,
                vy: Math.random() * 2 - 1,
                radius: Math.random() * 2 + 1,
                color: this.colors[Math.floor(Math.random() * this.colors.length)]
            });
        }
    }

    bindEvents() {
        window.addEventListener('resize', () => this.resize());
        window.addEventListener('mousemove', (e) => {
            this.mousePosition.x = e.clientX;
            this.mousePosition.y = e.clientY;
        });
    }

    drawParticles() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        this.particles.forEach((particle, i) => {
            // Update position
            particle.x += particle.vx;
            particle.y += particle.vy;

            // Bounce off edges
            if (particle.x < 0 || particle.x > this.canvas.width) particle.vx *= -1;
            if (particle.y < 0 || particle.y > this.canvas.height) particle.vy *= -1;

            // Draw particle
            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
            this.ctx.fillStyle = particle.color;
            this.ctx.fill();

            // Draw connections
            for (let j = i + 1; j < this.particles.length; j++) {
                const particle2 = this.particles[j];
                const dx = particle.x - particle2.x;
                const dy = particle.y - particle2.y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < this.maxDistance) {
                    this.ctx.beginPath();
                    this.ctx.moveTo(particle.x, particle.y);
                    this.ctx.lineTo(particle2.x, particle2.y);
                    // Create a gradient connection based on both particles' colors
                    const gradient = this.ctx.createLinearGradient(
                        particle.x, particle.y,
                        particle2.x, particle2.y
                    );
                    gradient.addColorStop(0, particle.color);
                    gradient.addColorStop(1, particle2.color);
                    this.ctx.strokeStyle = gradient;
                    this.ctx.globalAlpha = 1 - distance / this.maxDistance;
                    this.ctx.stroke();
                    this.ctx.globalAlpha = 1;
                }
            }

            // Draw connection to mouse
            const dx = particle.x - this.mousePosition.x;
            const dy = particle.y - this.mousePosition.y;
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < this.maxDistance) {
                this.ctx.beginPath();
                this.ctx.moveTo(particle.x, particle.y);
                this.ctx.lineTo(this.mousePosition.x, this.mousePosition.y);
                this.ctx.strokeStyle = particle.color;
                this.ctx.globalAlpha = 1 - distance / this.maxDistance;
                this.ctx.stroke();
                this.ctx.globalAlpha = 1;
            }
        });
    }

    animate() {
        this.drawParticles();
        requestAnimationFrame(() => this.animate());
    }
}

// Initialize the particle network when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('particle-canvas');
    new ParticleNetwork(canvas);
}); 
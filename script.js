// Menu burger toggle
document.getElementById('menu-toggle').addEventListener('click', () => {
    const navMenu = document.getElementById('nav-menu');
    navMenu.classList.toggle('hidden');
    navMenu.classList.toggle('open');
});

// Animation de défilement pour les formations
document.addEventListener('scroll', () => {
    const formationItems = document.querySelectorAll('.formation-item');
    formationItems.forEach(item => {
        const rect = item.getBoundingClientRect();
        if (rect.top <= window.innerHeight * 0.8) {
            item.classList.remove('opacity-0', '-translate-x-12', 'translate-x-12');
            item.classList.add('opacity-100', 'translate-x-0');
        }
    });
});

// Animation de fond avec cercles
const canvas = document.getElementById('backgroundCanvas');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

class Circle {
    constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 8 + 3;
        this.speedX = Math.random() * 0.5 - 0.25;
        this.speedY = Math.random() * 0.5 - 0.25;
        this.hue = Math.random() * 360;
    }
    update() {
        this.x += this.speedX;
        this.y += this.speedY;
        if (this.x < 0 || this.x > canvas.width) this.speedX = -this.speedX;
        if (this.y < 0 || this.y > canvas.height) this.speedY = -this.speedY;
        this.hue = (this.hue + 0.5) % 360;
    }
    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fillStyle = `hsl(${this.hue}, 50%, 30%)`;
        ctx.fill();
    }
}

const circles = [];
for (let i = 0; i < 30; i++) circles.push(new Circle());

function animate() {
    ctx.fillStyle = 'rgba(17, 24, 39, 0.1)';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    circles.forEach(circle => {
        circle.update();
        circle.draw();
    });
    requestAnimationFrame(animate);
}
animate();

// Gestion des filtres pour les projets
const filterButtons = document.querySelectorAll('.filter-btn');
const projectItems = document.querySelectorAll('.project-item');

filterButtons.forEach(button => {
    button.addEventListener('click', () => {
        filterButtons.forEach(btn => {
            btn.classList.remove('bg-cyan-500', 'hover:bg-cyan-600');
            btn.classList.add('bg-gray-700', 'hover:bg-gray-600');
        });
        button.classList.remove('bg-gray-700', 'hover:bg-gray-600');
        button.classList.add('bg-cyan-500', 'hover:bg-cyan-600');

        const filter = button.getAttribute('data-filter');
        projectItems.forEach(item => {
            const categories = item.getAttribute('data-category').split(' ');
            if (filter === 'all' || categories.includes(filter)) {
                item.style.display = 'block';
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'scale(1)';
                }, 10);
            } else {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 300);
            }
        });
    });
});

// Initialisation de Vanilla Tilt
VanillaTilt.init(document.querySelectorAll(".tilt"), {
    max: 15,
    speed: 400,
    glare: true,
    "max-glare": 0.5
});

// Animation des barres de progression pour la section "Compétences"
document.addEventListener('scroll', () => {
    const skillBars = document.querySelectorAll('#competences .bg-gray-700 .bg-orange-500, #competences .bg-gray-700 .bg-green-500, #competences .bg-gray-700 .bg-yellow-500, #competences .bg-gray-700 .bg-purple-500, #competences .bg-gray-700 .bg-pink-500');
    skillBars.forEach(bar => {
        const rect = bar.getBoundingClientRect();
        if (rect.top <= window.innerHeight * 0.8 && bar.style.width === '0%') {
            const targetWidth = bar.getAttribute('data-width');
            bar.style.width = targetWidth;
        }
    });
});

// Animation pour les objectifs
document.addEventListener('scroll', () => {
    const objectifItems = document.querySelectorAll('.objectif-item');
    objectifItems.forEach(item => {
        const rect = item.getBoundingClientRect();
        if (rect.top <= window.innerHeight * 0.8) {
            item.classList.remove('opacity-0', '-translate-x-12', 'translate-x-12');
            item.classList.add('opacity-100', 'translate-x-0');
        }
    });
});

// Animation pour les expériences
document.addEventListener('scroll', () => {
    const experienceItems = document.querySelectorAll('.experience-item');
    experienceItems.forEach(item => {
        const rect = item.getBoundingClientRect();
        if (rect.top <= window.innerHeight * 0.8) {
            item.classList.remove('opacity-0', 'translate-y-12');
            item.classList.add('opacity-100', 'translate-y-0');
        }
    });
});
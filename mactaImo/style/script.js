document.addEventListener("DOMContentLoaded", function () {
    // Animation d'entrée du header
    const header = document.querySelector("header");
    header.style.opacity = "0";
    header.style.transform = "translateY(-30px)";
    setTimeout(() => {
        header.style.transition = "opacity 1s ease-out, transform 1s ease-out";
        header.style.opacity = "1";
        header.style.transform = "translateY(0)";
    }, 500);

    // Effet au survol du logo
    const logo = document.querySelector("#logo img");
    logo.addEventListener("mouseenter", () => {
        logo.style.transition = "transform 0.3s ease";
        logo.style.transform = "rotate(10deg)";
    });
    logo.addEventListener("mouseleave", () => {
        logo.style.transform = "rotate(0deg)";
    });

    // Animation du texte du slogan (effet de frappe)
    const sloganText = document.querySelector("#slogan #text");
    const text = "La passion transforme les rêves en réalité.";
    sloganText.textContent = "";
    let i = 0;
    function typeWriter() {
        if (i < text.length) {
            sloganText.textContent += text.charAt(i);
            i++;
            setTimeout(typeWriter, 50);
        }
    }
    setTimeout(typeWriter, 1000);

    // Effet de défilement sur la section "À Propos"
    const aPropos = document.querySelector("#aPropos");
    function revealOnScroll() {
        const rect = aPropos.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        if (rect.top < windowHeight - 100) {
            aPropos.style.opacity = "1";
            aPropos.style.transform = "translateY(0)";
            window.removeEventListener("scroll", revealOnScroll);
        }
    }

    aPropos.style.opacity = "0";
    aPropos.style.transform = "translateY(50px)";
    aPropos.style.transition = "opacity 1s ease-out, transform 1s ease-out";

    window.addEventListener("scroll", revealOnScroll);
});


/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

require ('bootstrap');


document.addEventListener("DOMContentLoaded", function(event) {
    const copyButtonLabel = "<i class='fas fa-copy' style='color:#3c3f42'></i>";
    const copiedButtonLabel = "kopiert <i class='fas fa-check' style='color:#06c'></i>";

    let button = document.getElementById("myBtn");
    let buttonParent = button.parentNode;

    function myFunction() {
        if (document.body.scrollTop  >= 150 || document.documentElement.scrollTop >= 150) {
            button.style.display = "inline-block";
            button.style.opacity = "1";
            //button.classList.replace("d-none","d-inline-block");
        } else {
            button.style.opacity = "0";
            button.style.display = "none";
            //button.classList.replace("d-inline-block","d-none");
            //button.remove();
        }
    }
    function topFunction(e) {
        e.preventDefault();
        window.scrollTo({top: 0, behavior: 'smooth'});
        //document.body.scrollTop = 0; // For Safari
        //document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
    button.addEventListener("click",topFunction);
    window.onscroll = function () {
        myFunction()
    };

    // use a class selector if available
    let blocks = document.querySelectorAll("pre");

    blocks.forEach((block) => {
        // only add button if browser supports Clipboard API
        if (navigator.clipboard) {
            let button = document.createElement("button");
            block.appendChild(button);
            button.innerHTML = copyButtonLabel;
            button.addEventListener("click", async () => {
                await copyCode(block);
                await rollBackButtonText(button);
            });
        }
    });

    function Sleep(milliseconds) {
        return new Promise(resolve => setTimeout(resolve, milliseconds));
    }

    async function copyCode(block) {
        let code = block.querySelector("code");
        let text = code.innerText;
        await navigator.clipboard.writeText(text);
    }

    async function rollBackButtonText(button) {
        button.innerHTML = copiedButtonLabel;
        await Sleep(1000); // Pausiert die Funktion für 3 Sekunden
        button.innerHTML = copyButtonLabel;
    }
});

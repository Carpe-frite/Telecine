document.addEventListener('turbo:load', () => {

    const genre_checkbox= document.querySelectorAll('.genre-checkbox');
    document.querySelectorAll('.genre-checkbox:checked').forEach(checkbox => params.append(checkbox.value))

    window.showHiddenMenu = function() {
        if (document.getElementById("hiddenMenu").classList.contains("hidden")) {
            document.getElementById("hiddenMenu").classList.remove("hidden");
            document.getElementById("hiddenMenu").classList.add("block");
        }
        else if (document.getElementById("hiddenMenu").classList.contains("block")) {
            document.getElementById("hiddenMenu").classList.remove("block");
            document.getElementById("hiddenMenu").classList.add("hidden");
        }
    }

    window.hideHiddenMenu = function() {
        if (document.getElementById("hiddenMenu").classList.contains("block")) {
            document.getElementById("hiddenMenu").classList.remove("block");
            document.getElementById("hiddenMenu").classList.add("hidden");
        }
    }

    window.fetchFilteredEvent = async function() {
        const params = new URLSearchParams();
        document.querySelectorAll('.genre-checkbox:checked').forEach(checkbox => params.append('genres[]', checkbox.value))
        try {
            const response = await fetch('/get-events-filtered?' + params.toString());
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            const responsed_html = await response.text();
            document.getElementById('latest-events').outerHTML = responsed_html;

        }
        catch(error) {
            console.error(error.message);
        }
    }

    genre_checkbox.forEach (checkbox => {
        checkbox.addEventListener('change', fetchFilteredEvent);
    });

});
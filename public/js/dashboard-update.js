function initDashboardUpdate(apiUrl, updateInterval) {
    function updateDashboard() {
        // Récupère les données de l'API
        axios.get(apiUrl)
            .then(response => {
                const data = response.data;
                // Parcoure chaque module dans les données reçues
                data.forEach(moduleData => {
                    const moduleId = moduleData.moduleId;
                    const temperature = moduleData.temperature;
                    const energy = moduleData.energy;
                    const createdAt = moduleData.createdAt;
                    const broken = moduleData.broken;

                    // Récupère les éléments du DOM associés à chaque module
                    const temperatureElement = document.querySelector(`#temperature-${moduleId}`);
                    const energyElement = document.querySelector(`#energy-${moduleId}`);
                    const createdAtElement = document.querySelector(`#created-at-${moduleId}`);
                    const brokenElement = document.querySelector(`#broken-${moduleId}`);
                    const cardElement = document.querySelector(`#card-${moduleId}`);

                    // Vérifie si tous les éléments du DOM sont présents
                    if (temperatureElement && energyElement && createdAtElement && brokenElement && cardElement) {

                        // Mise à jour de l'état de fonctionnement du module
                        brokenElement.textContent = broken ? 'Oui' : 'Non';
                        brokenElement.classList.toggle('text-danger', broken);
                        brokenElement.classList.toggle('text-success', !broken);

                        // Change la couleur de la carte selon l'état de fonctionnement du module
                        cardElement.classList.toggle('bg-danger', broken);
                        cardElement.classList.toggle('bg-primary', !broken);

                        // Mise à jour des valeurs de température, d'énergie et date de création
                        temperatureElement.innerHTML = `<i class="text-info ml-2"></i> ${temperature}°C`;
                        energyElement.innerHTML = `<i class="text-warning ml-2"></i> ${energy}W/m`;
                        createdAtElement.textContent = createdAt;
                    }
                });
            })
            .catch(error => {
                console.error(error);
            });
    }
    // Lance la mise à jour du tableau de bord à un intervalle défini
    setInterval(updateDashboard, updateInterval);
}

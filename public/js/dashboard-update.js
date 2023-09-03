function initDashboardUpdate(apiUrl, updateInterval) {
    function updateDashboard() {
        axios.get(apiUrl)
            .then(response => {
                const data = response.data;
                data.forEach(moduleData => {
                    const moduleId = moduleData.moduleId;
                    const temperature = moduleData.temperature;
                    const energy = moduleData.energy;
                    const createdAt = moduleData.createdAt;
                    const broken = moduleData.broken;

                    const temperatureElement = document.querySelector(`#temperature-${moduleId}`);
                    const energyElement = document.querySelector(`#energy-${moduleId}`);
                    const createdAtElement = document.querySelector(`#created-at-${moduleId}`);
                    const brokenElement = document.querySelector(`#broken-${moduleId}`);
                    const cardElement = document.querySelector(`#card-${moduleId}`);

                    if (temperatureElement && energyElement && createdAtElement && brokenElement && cardElement) {
                        
                        brokenElement.textContent = broken ? 'Oui' : 'Non';
                        brokenElement.classList.toggle('text-danger', broken);
                        brokenElement.classList.toggle('text-success', !broken);

                        
                        cardElement.classList.toggle('bg-danger', broken);
                        cardElement.classList.toggle('bg-primary', !broken);

                        
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

    setInterval(updateDashboard, updateInterval);
}


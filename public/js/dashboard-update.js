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

                    const temperatureElement = document.querySelector(`#temperature-${moduleId}`);
                    const energyElement = document.querySelector(`#energy-${moduleId}`);
                    const createdAtElement = document.querySelector(`#created-at-${moduleId}`);

                    if (temperatureElement && energyElement && createdAtElement) {
                        temperatureElement.textContent = temperature;
                        energyElement.textContent = energy;
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

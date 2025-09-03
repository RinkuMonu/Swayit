fetch(`/api/live-influencer-search?q=${encodeURIComponent(q)}`)
    .then(r => r.json())
    .then(json => {
        lastResults = json.results;
        wrapper.style.display = 'block';
        container.innerHTML = ''; // Clear existing content before adding new
        influencerCountElement.style.display = 'none'; // Hide count initially

        if (lastResults.length > 0) {
            lastResults.forEach(influencer => {
                const card = document.createElement('div');
                card.className = 'col-xl-4 col-sm-6 mb-3';
                card.innerHTML = `
                    <div class="card">
                        <div class="card-body">
                            <img src="${influencer.profile_image}" class="img-fluid mb-2" />
                            <h5>${influencer.name}</h5>
                            <p>${influencer.bio || ''}</p>
                            <span class="badge bg-info">${influencer.platform}</span>
                            <a href="${influencer.profile_url}" target="_blank" class="btn btn-primary btn-sm mt-2">View Profile</a>
                        </div>
                    </div>`;
                container.appendChild(card);
            });

            influencerCountElement.textContent = `Found ${lastResults.length} influencers.`;
            influencerCountElement.style.display = 'block'; // Show count

            container.classList.add('content-hidden'); // Apply blur AFTER adding cards
            contentOverlay.style.display = 'block';    // Show overlay
        } else {
            influencerCountElement.textContent = 'No influencers found.';
            influencerCountElement.style.display = 'block';
            container.classList.remove('content-hidden');
            contentOverlay.style.display = 'none';
        }
    })

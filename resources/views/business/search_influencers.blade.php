@extends('influencer.layout.main')

@section('content')

<div class="container-fluid">
    <h3>Influencer List</h3>

    {{-- Flash Message --}}
    <div id="flashMessage" class="alert alert-success d-none" role="alert">
        Notification sent successfully!
    </div>

    <div class="mb-3">
        <input id="liveSearch" class="form-control" type="search" placeholder="Search skills, business, tags...">
    </div>

    {{-- Display count here --}}
    <p id="influencerCount" class="text-muted" style="display:none;"></p>

    {{-- Influencer Result Wrapper --}}
    <div id="influencerWrapper" style="display:none; position: relative;">
        {{-- Overlay to cover blurred content --}}
        <div id="contentOverlay" class="content-hidden-overlay" style="display:none;"></div>

        <div class="row mt-4" id="influencerResult"></div>

        {{-- Notify Button --}}
        <div class="text-center mt-3" style="position: relative; z-index: 20;">
            <button class="btn btn-warning" id="notifyInfluencers">Notify Influencers</button>
        </div>
    </div>
</div>

<style>
    /* Add this to your style block */
    .content-hidden {
        filter: blur(20px); /* Very strong blur */
        opacity: 0.1; /* Make it almost invisible */
        transition: filter 0.3s ease-in-out, opacity 0.3s ease-in-out;
    }

    .content-hidden-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.9); /* Almost opaque white */
        z-index: 5;
        pointer-events: none;
    }
</style>

<script>
    // Debounce function with a cancel method
    const debounce = (fn, delay) => {
        let timer;
        let debounced = function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
        debounced.cancel = () => { // Add a cancel method to clear the timeout
            clearTimeout(timer);
        };
        return debounced;
    };

    let lastResults = [];
    const influencerCountElement = document.getElementById('influencerCount');
    const contentOverlay = document.getElementById('contentOverlay');
    const liveSearchInput = document.getElementById('liveSearch'); // Get the input element

    // Function to perform the search (wrapped in debounce outside, called directly here)
    const executeSearch = () => {
        const q = liveSearchInput.value.trim(); // Use liveSearchInput.value
        const container = document.getElementById('influencerResult');
        const wrapper = document.getElementById('influencerWrapper');
        container.innerHTML = '';
        influencerCountElement.style.display = 'none'; // Hide count initially
        contentOverlay.style.display = 'none'; // Hide overlay initially

        if (q.length < 3) {
            wrapper.style.display = 'none';
            container.classList.remove('content-hidden'); // Ensure content is not blurred
            return;
        }

        fetch(`/api/live-influencer-search?q=${encodeURIComponent(q)}`)
            .then(r => r.json())
            .then(json => {
                lastResults = json.results;
                wrapper.style.display = 'block';
                container.innerHTML = ''; // Clear existing content before adding new

                if (lastResults.length > 0) {
                    influencerCountElement.textContent = `Found ${lastResults.length} influencers.`;
                    influencerCountElement.style.display = 'block'; // Show count
                    container.classList.add('content-hidden'); // Apply blur to content
                    contentOverlay.style.display = 'block'; // Show the overlay
                } else {
                    influencerCountElement.textContent = 'No influencers found.';
                    influencerCountElement.style.display = 'block';
                    container.classList.remove('content-hidden'); 
                    contentOverlay.style.display = 'none';
                }

                json.results.forEach(influencer => {
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
            })
            .catch(error => {
                console.error('Error fetching influencers:', error);
                influencerCountElement.textContent = 'Error fetching influencers.';
                influencerCountElement.style.display = 'block';
                wrapper.style.display = 'none'; 
            });
    };

    // Create a debounced version of executeSearch for the 'input' event
    const debouncedSearch = debounce(executeSearch, 300);

    // Event listener for 'input' (live search as you type)
    liveSearchInput.addEventListener('input', debouncedSearch);

    // New: Event listener for 'keydown' (to handle Enter key)
    liveSearchInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent default form submission or other browser behavior
            debouncedSearch.cancel(); // Cancel any pending debounced calls from 'input'
            executeSearch(); // Immediately perform the search without debounce
        }
    });

    document.getElementById('notifyInfluencers').addEventListener('click', function () {
        if (!lastResults.length) {
            alert('No influencers to notify!'); // Inform the user
            return;
        }

        fetch('/api/notify-influencers', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ influencers: lastResults })
        })
        .then(r => {
            if (!r.ok) { // Check for HTTP errors
                return r.json().then(err => Promise.reject(err));
            }
            return r.json();
        })
        .then(data => {
            const flash = document.getElementById('flashMessage');
            flash.classList.remove('d-none');
            flash.textContent = data.message || 'Notification sent!';

            setTimeout(() => {
                flash.classList.add('d-none');
            }, 5000);

            const container = document.getElementById('influencerResult'); // Get the container
            container.classList.remove('content-hidden'); // Remove blur from content
            contentOverlay.style.display = 'none'; // Hide the overlay
        })
        .catch(error => {
            console.error('Error notifying influencers:', error);
            const flash = document.getElementById('flashMessage');
            flash.classList.remove('d-none', 'alert-success');
            flash.classList.add('alert-danger'); // Use danger alert for errors
            flash.textContent = error.message || 'Failed to send notification.';
            setTimeout(() => {
                flash.classList.add('d-none', 'alert-danger');
                flash.classList.remove('alert-success');
            }, 5000);
        });
    });
</script>

@endsection
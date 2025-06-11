<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boîte à Idées Communautaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#5D5CDE',
                        'primary-hover': '#4845B8',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    <div class="min-h-screen">
      @include('template.header')

        @yield('content')
    
    </div>

    <!-- <script>
        // Gestion du mode sombre
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            if (event.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });

        // Stockage des données en mémoire
        let ideas = [
            {
                id: 1,
                title: "Installer des bancs dans le parc central",
                description: "Il serait bien d'avoir plus de bancs pour que les familles puissent se reposer lors des promenades.",
                author: "Marie Dupont",
                votes: 12,
                timestamp: Date.now() - 86400000
            },
            {
                id: 2,
                title: "Créer un jardin partagé",
                description: "Un espace où les habitants peuvent cultiver ensemble des légumes et des herbes aromatiques.",
                author: "Jean Martin",
                votes: 8,
                timestamp: Date.now() - 172800000
            }
        ];

        let nextId = 3;

        // Éléments du DOM
        const ideaForm = document.getElementById('ideaForm');
        const ideasContainer = document.getElementById('ideasContainer');
        const noIdeasMessage = document.getElementById('noIdeasMessage');
        const totalIdeasEl = document.getElementById('totalIdeas');
        const totalVotesEl = document.getElementById('totalVotes');
        const topVotesEl = document.getElementById('topVotes');
        const sortSelect = document.getElementById('sortSelect');
        const searchInput = document.getElementById('searchInput');

        // Fonction pour afficher les statistiques
        function updateStats() {
            const totalIdeas = ideas.length;
            const totalVotes = ideas.reduce((sum, idea) => sum + idea.votes, 0);
            const topVotes = ideas.length > 0 ? Math.max(...ideas.map(idea => idea.votes)) : 0;

            totalIdeasEl.textContent = totalIdeas;
            totalVotesEl.textContent = totalVotes;
            topVotesEl.textContent = topVotes;
        }

        // Fonction pour créer une carte d'idée
        function createIdeaCard(idea) {
            const timeAgo = getTimeAgo(idea.timestamp);
            
            return `
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white pr-4">${escapeHtml(idea.title)}</h3>
                        <div class="flex items-center space-x-2 flex-shrink-0">
                            <button onclick="voteForIdea(${idea.id})" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center space-x-1">
                                <span>👍</span>
                                <span>${idea.votes}</span>
                            </button>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">${escapeHtml(idea.description)}</p>
                    
                    <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                        <span class="flex items-center">
                            <span class="mr-1">👤</span>
                            ${escapeHtml(idea.author)}
                        </span>
                        <span class="flex items-center">
                            <span class="mr-1">🕒</span>
                            ${timeAgo}
                        </span>
                    </div>
                </div>
            `;
        }

        // Fonction pour échapper le HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Fonction pour calculer le temps écoulé
        function getTimeAgo(timestamp) {
            const now = Date.now();
            const diff = now - timestamp;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(diff / 3600000);
            const days = Math.floor(diff / 86400000);

            if (days > 0) return `il y a ${days} jour${days > 1 ? 's' : ''}`;
            if (hours > 0) return `il y a ${hours} heure${hours > 1 ? 's' : ''}`;
            if (minutes > 0) return `il y a ${minutes} minute${minutes > 1 ? 's' : ''}`;
            return 'à l\'instant';
        }

        // Fonction pour voter pour une idée
        function voteForIdea(id) {
            const idea = ideas.find(i => i.id === id);
            if (idea) {
                idea.votes++;
                displayIdeas();
                updateStats();
                
                // Animation de feedback
                const button = event.target.closest('button');
                button.classList.add('scale-110');
                setTimeout(() => button.classList.remove('scale-110'), 150);
            }
        }

        // Fonction pour trier et filtrer les idées
        function getSortedAndFilteredIdeas() {
            let filteredIdeas = [...ideas];
            
            // Filtrage par recherche
            const searchTerm = searchInput.value.toLowerCase().trim();
            if (searchTerm) {
                filteredIdeas = filteredIdeas.filter(idea =>
                    idea.title.toLowerCase().includes(searchTerm) ||
                    idea.description.toLowerCase().includes(searchTerm) ||
                    idea.author.toLowerCase().includes(searchTerm)
                );
            }
            
            // Tri
            const sortBy = sortSelect.value;
            switch (sortBy) {
                case 'newest':
                    filteredIdeas.sort((a, b) => b.timestamp - a.timestamp);
                    break;
                case 'oldest':
                    filteredIdeas.sort((a, b) => a.timestamp - b.timestamp);
                    break;
                case 'most-votes':
                    filteredIdeas.sort((a, b) => b.votes - a.votes);
                    break;
                case 'least-votes':
                    filteredIdeas.sort((a, b) => a.votes - b.votes);
                    break;
            }
            
            return filteredIdeas;
        }

        // Fonction pour afficher les idées
        function displayIdeas() {
            const filteredIdeas = getSortedAndFilteredIdeas();
            
            if (filteredIdeas.length === 0) {
                ideasContainer.innerHTML = '';
                noIdeasMessage.style.display = 'block';
            } else {
                noIdeasMessage.style.display = 'none';
                ideasContainer.innerHTML = filteredIdeas.map(createIdeaCard).join('');
            }
        }

        // Gestionnaire de soumission du formulaire
        ideaForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const author = document.getElementById('author').value.trim();
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            
            if (author && title && description) {
                const newIdea = {
                    id: nextId++,
                    title,
                    description,
                    author,
                    votes: 0,
                    timestamp: Date.now()
                };
                
                ideas.unshift(newIdea);
                displayIdeas();
                updateStats();
                
                // Reset du formulaire
                ideaForm.reset();
                
                // Animation de feedback
                const submitButton = ideaForm.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<span>✅</span><span>Idée ajoutée !</span>';
                submitButton.disabled = true;
                
                setTimeout(() => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }, 2000);
            }
        });

        // Gestionnaires pour le tri et la recherche
        sortSelect.addEventListener('change', displayIdeas);
        searchInput.addEventListener('input', displayIdeas);

        // Initialisation
        displayIdeas();
        updateStats();

        // Rendre la fonction voteForIdea globale
        window.voteForIdea = voteForIdea;
    </script> -->
</body>
</html>
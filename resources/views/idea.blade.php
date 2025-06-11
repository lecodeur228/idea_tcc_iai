@extends('index')

@section('content')


<div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Formulaire d'ajout d'idée -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 mb-8 shadow-sm border border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <span class="mr-2">✨</span>
                    Proposer une nouvelle idée
                </h2>
                
                <form method='POST' action="{{ route('store') }}" id="ideaForm" class="space-y-4">
                    @csrf
                    <div>
                        <label for="author" class="block text-sm font-medium mb-2">Votre nom</label>
                        <input 
                            type="text" 
                            id="author" 
                            name="author"
                            required
                            class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                            placeholder="Entrez votre nom..."
                        >
                    </div>
                    
                    <div>
                        <label for="title" class="block text-sm font-medium mb-2">Titre de l'idée</label>
                        <input 
                            type="text" 
                            id="title"
                            name="title" 
                            required
                            class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                            placeholder="Un titre accrocheur pour votre idée..."
                        >
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium mb-2">Description détaillée</label>
                        <textarea 
                            id="description" 
                            required
                            name="description"
                            rows="4"
                            class="w-full px-4 py-3 text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all resize-none"
                            placeholder="Décrivez votre idée en détail..."
                        ></textarea>
                    </div>
                    
                    <button 
                        type="submit"
                        class="w-full bg-primary hover:bg-primary-hover text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2"
                    >
                        <span>🚀</span>
                        <span>Soumettre l'idée</span>
                    </button>
                </form>
            </div>

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400" id="totalIdeas">0</div>
                    <div class="text-sm text-blue-700 dark:text-blue-300">Idées proposées</div>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400" id="totalVotes">0</div>
                    <div class="text-sm text-green-700 dark:text-green-300">Votes au total</div>
                </div>
                <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400" id="topVotes">0</div>
                    <div class="text-sm text-purple-700 dark:text-purple-300">Votes max</div>
                </div>
            </div>

            <!-- Filtres et tri -->
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <select id="sortSelect" class="px-4 py-2 text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-primary focus:border-transparent outline-none">
                    <option value="newest">Plus récentes</option>
                    <option value="oldest">Plus anciennes</option>
                    <option value="most-votes">Plus de votes</option>
                    <option value="least-votes">Moins de votes</option>
                </select>
                
                <input 
                    type="text" 
                    id="searchInput"
                    placeholder="Rechercher une idée..."
                    class="flex-1 px-4 py-2 text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-primary focus:border-transparent outline-none"
                >
            </div>

            <!-- Liste des idées -->
            <div class="space-y-4" id="ideasContainer">
                <!-- Les idées seront ajoutées ici dynamiquement -->
                @foreach($ideas as $idea)
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white pr-4">{{$idea->title}}</h3>
                        <div class="flex items-center space-x-2 flex-shrink-0">
                            <button onclick="voteForIdea(${idea.id})" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center space-x-1">
                                <span>👍</span>
                                <span>{{$idea->votes}}</span>
                            </button>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">{{$idea->description}}</p>
                    
                    <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                        <span class="flex items-center">
                            <span class="mr-1">👤</span>
                            {{$idea->author}}
                        </span>
                        <span class="flex items-center">
                            <span class="mr-1">🕒</span>
                            {{ $idea->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Message si aucune idée -->
           @if(count($ideas) == 0)
           <div id="noIdeasMessage" class="text-center py-12 text-gray-500 dark:text-gray-400">
                <div class="text-6xl mb-4">💭</div>
                <h3 class="text-xl font-semibold mb-2">Aucune idée pour le moment</h3>
                <p>Soyez le premier à proposer une idée pour améliorer notre communauté !</p>
            </div>
            @endif
        </div>

@endsection

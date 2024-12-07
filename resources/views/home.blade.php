<x-guest-layout>
    <div>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Bienvenue sur le Larablog !
        </h2> 

        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Voici les 3 articles en tendance en ce moment :
        </h3>
        <!-- Articles -->
        @foreach ($articles as $article)
        <div>
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-2xl font-bold">{{ $article->title }}</h2>
                @foreach ($article->categories as $category)
                    {{ $category->name }}
                @endforeach
                <p class="text-gray-700 dark:text-gray-300">{{ substr($article->content, 0, 30) }}...</p>
                
                <a href="{{ route('public.show', [$article->user_id, $article->id]) }}" class="text-red-500 hover:text-red-700">Lire la suite</a>
            </div>
        </div>
        <hr>
        @endforeach

        <a href="{{ route('public.liste') }}" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
            <span>Voir tout les articles</span>
        </a>
    </div>
</x-guest-layout>
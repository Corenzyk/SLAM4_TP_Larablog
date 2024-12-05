<a href="{{ route('public.index', $article->user->id) }}"><- Retour sur les articles</a>
<x-guest-layout>
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $article->title }}
    </h2>
    
    @foreach ($article->categories as $category)
        {{ $category->name }}
    @endforeach

    <div class="text-gray-500 text-sm">
        Publié le {{ $article->created_at->format('d/m/Y') }} par <a href="{{ route('public.index', $article->user->id) }}">{{ $article->user->name }}</a>
    </div>

    <div>
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <p class="text-gray-700 dark:text-gray-300">{{ $article->content }}</p>
        </div>
    </div>

    @foreach ($article->comments as $comment)
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
        </div>
    @endforeach

    @auth
        <form action="{{ route('comments.store') }}" method="post" class="mt-6">
            @csrf
            <input type="hidden" name="articleId" value="{{ $article->id }}">

            <input name="content" id="content" type="text" class="form-control" placeholder="Écrivez votre message ici..." required />
            <button type="submit" class="btn btn-primary">Envoyer</button>

            @if(session('error'))
                <div class="alert alert-danger mt-2">{{ session('error') }}</div>
            @endif
        </form>
    @endauth
</x-guest-layout>
<a href="{{ route('user_update_account') }}">Gérer mon compte</a>
<a href="{{ route('user_cellar_list') }}">Mes caves</a>
@if ($is_eligible_to_club_premium)
    <a href="{{ route('club_premium') }}">Club Premium</a>
@endif

<a href="{{ route('user_logout') }}">Déconnexion</a>

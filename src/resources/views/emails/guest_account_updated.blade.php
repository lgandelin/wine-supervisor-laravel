Bonjour,<br><br>

votre accès au <a href="{{ $urlClubPremium }}">Club Avantage</a> WineSupervisor a été modifié.<br><br>

Vous trouverez ci-dessous les nouvelles informations pour vous y connecter.<br><br>

Il vous permettra d'accéder aux ventes en cours, à partir du {{ $startDate->format('d/m/Y') }} jusqu'au {{ $endDate->format('d/m/Y') }}.<br/><br/>

<strong>Login : </strong>{{ $login }}<br><br>

<strong>Mot de passe : </strong>@if ($passwordUpdated){{ $password }}@else{{ 'Vous seul le connaissez' }}@endif<br><br>

Vous pouvez accéder directement au Club Avantage en <a href="{{ $urlClubPremium }}">cliquant içi</a>.<br/><br/>

Cordialement,<br><br>

L'équipe WineSupervisor<br/><br/>

---<br><br>

<i>Ceci est un mail automatique, merci de ne pas y répondre.</i>
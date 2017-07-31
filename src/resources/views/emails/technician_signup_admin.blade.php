Bonjour,<br><br>

un nouveau compte installateur WineSupervisor a été créé depuis le site.<br>
Il est en attente de votre validation.<br><br>

<strong>Email : </strong>{{ $technician->email }}<br><br>

<strong>Téléphone : </strong>{{ $technician->phone }}<br><br>

<strong>Société : </strong>{{ $technician->company }}<br><br>

<strong>Immatriculation : </strong>{{ $technician->registration }}<br><br>

<strong>Adresse : </strong>{{ $technician->address }} {{ $technician->address2 }}<br><br>

<strong>Ville : </strong>{{ $technician->city }}<br><br>

<strong>Pays : </strong>{{ $technician->country }}<br><br>

Vous pouvez accéder directement à la fiche de l'installateur dans le back-office en <a href="{{ route('admin_technician_update', ['uuid' => $technician->id]) }}">cliquant içi</a>.<br/><br/>

---<br><br>

<i>Ceci est un mail automatique, merci de ne pas y répondre.</i>
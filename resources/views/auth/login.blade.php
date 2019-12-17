
<form action="{{route('processLogin')}}" method="post">
    @csrf
    <input type="text" name="email">
    <input type="password" name="password">
    <button>Přihlásit se</button>
</form>
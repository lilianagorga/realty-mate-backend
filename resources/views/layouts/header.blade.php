<nav class="card m-4 rounded px-4 py-5">
    <div class="container flex flex-wrap justify-between items-center mx-auto">
        @auth
            <li>
                <form method="POST" class="inline users" action="/logout">
                    @csrf
                    <button type="submit">
                        <i class="fa-solid fa-door-closed"></i>Logout
                    </button>
                </form>
            </li>
        @else
            <li>
                <a href="/register" class="users"><i class="fa-solid fa-user-plus"></i> Register</a>
            </li>
            <li>
                <a href="/login" class="users"><i class="fa-solid fa-arrow-right-to-bracket"></i>Login</a>
            </li>
        @endauth
    </div>
</nav>


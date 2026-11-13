<header class="dashboard-topbar">
  @if (!empty($search))
    <form class="topbar-search" method="GET" action="{{ route('admin.pengaduan.index') }}">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari pelanggan atau gangguan">
      @if (request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
      @endif
    </form>
  @else
    <div>
      <strong>LifeCare</strong>
      <span class="text-muted"> · Dukungan Lifemedia</span>
    </div>
  @endif

  <div class="topbar-actions">
    <button class="icon-btn" id="themeToggle" type="button" aria-label="Toggle dark mode">
      <i class="fa-solid fa-moon"></i>
    </button>
    <div class="user-chip">
      <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
      <div>
        <strong>{{ auth()->user()->name }}</strong>
        <p>{{ auth()->user()->isAdmin() ? 'Admin Lifemedia' : 'Tim Lifemedia' }}</p>
      </div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="btn btn-logout" type="submit">Keluar</button>
    </form>
  </div>
</header>

<script>
  const themeToggle = document.getElementById('themeToggle');
  const savedTheme = localStorage.getItem('lifecare-theme') || 'light';
  document.body.setAttribute('data-theme', savedTheme);
  themeToggle.innerHTML = savedTheme === 'dark'
    ? '<i class="fa-solid fa-sun"></i>'
    : '<i class="fa-solid fa-moon"></i>';
  themeToggle.addEventListener('click', () => {
    const next = document.body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    document.body.setAttribute('data-theme', next);
    localStorage.setItem('lifecare-theme', next);
    themeToggle.innerHTML = next === 'dark'
      ? '<i class="fa-solid fa-sun"></i>'
      : '<i class="fa-solid fa-moon"></i>';
  });
</script>

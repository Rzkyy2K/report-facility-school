import { ChangeEvent, FormEvent, ReactNode, useMemo, useState } from 'react'

type Tab = 'home' | 'report' | 'profile'
type Screen = Tab | 'all-reports'

type IconProps = {
  size?: number
  strokeWidth?: number
}

const Icon = ({
  children,
  size = 22,
  strokeWidth = 1.8,
}: IconProps & { children: ReactNode }) => (
  <svg
    width={size}
    height={size}
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    strokeWidth={strokeWidth}
    strokeLinecap="round"
    strokeLinejoin="round"
    aria-hidden="true"
  >
    {children}
  </svg>
)

const HomeIcon = (props: IconProps) => (
  <Icon {...props}>
    <path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1Z" />
  </Icon>
)
const PlusIcon = (props: IconProps) => (
  <Icon {...props}>
    <path d="M12 5v14M5 12h14" />
  </Icon>
)
const UserIcon = (props: IconProps) => (
  <Icon {...props}>
    <circle cx="12" cy="8" r="4" />
    <path d="M4 21a8 8 0 0 1 16 0" />
  </Icon>
)
const BellIcon = (props: IconProps) => (
  <Icon {...props}>
    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4" />
  </Icon>
)
const ArrowIcon = (props: IconProps) => (
  <Icon {...props}>
    <path d="m9 18 6-6-6-6" />
  </Icon>
)
const BackIcon = (props: IconProps) => (
  <Icon {...props}>
    <path d="m15 18-6-6 6-6" />
  </Icon>
)
const SearchIcon = (props: IconProps) => (
  <Icon {...props}>
    <circle cx="11" cy="11" r="7" />
    <path d="m20 20-4-4" />
  </Icon>
)
const CameraIcon = (props: IconProps) => (
  <Icon {...props}>
    <path d="M14.5 4 16 7h3a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h3l1.5-3Z" />
    <circle cx="12" cy="13" r="3" />
  </Icon>
)
const ChevronIcon = (props: IconProps) => (
  <Icon {...props}>
    <path d="m8 10 4 4 4-4" />
  </Icon>
)
const LogoutIcon = (props: IconProps) => (
  <Icon {...props}>
    <path d="M10 17l5-5-5-5M15 12H3M15 4h4a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-4" />
  </Icon>
)
const CheckIcon = (props: IconProps) => (
  <Icon {...props}>
    <path d="m5 12 4 4L19 6" />
  </Icon>
)

const reports = [
  {
    item: 'Proyektor tidak menyala',
    room: 'Lab Komputer 2',
    major: 'RPL',
    time: 'Hari ini, 09.24',
    status: 'Sedang diperiksa',
    statusClass: 'amber',
    image:
      'https://images.unsplash.com/photo-1670924786856-9ae9882ca224?auto=format&fit=crop&w=240&q=80',
  },
  {
    item: 'Kursi patah',
    room: 'Ruang Kelas XI TKJ 1',
    major: 'TKJ',
    time: 'Kemarin, 14.10',
    status: 'Dalam perbaikan',
    statusClass: 'blue',
    image:
      'https://images.unsplash.com/photo-1503602642458-232111445657?auto=format&fit=crop&w=240&q=80',
  },
  {
    item: 'Kipas angin berisik',
    room: 'Ruang Kelas X DKV 2',
    major: 'DKV',
    time: '12 Juni, 10.42',
    status: 'Laporan diterima',
    statusClass: 'violet',
    image:
      'https://images.unsplash.com/photo-1628308242811-7f00c3a991f0?auto=format&fit=crop&w=240&q=80',
  },
  {
    item: 'Lampu kelas mati',
    room: 'Ruang Kelas XII RPL 2',
    major: 'RPL',
    time: '11 Juni, 08.15',
    status: 'Selesai',
    statusClass: 'green',
    image:
      'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=240&q=80',
  },
  {
    item: 'Keyboard komputer rusak',
    room: 'Lab Komputer 1',
    major: 'TKJ',
    time: '10 Juni, 13.20',
    status: 'Dalam perbaikan',
    statusClass: 'blue',
    image:
      'https://images.unsplash.com/photo-1643199121319-b3b5695e4acb?auto=format&fit=crop&w=240&q=80',
  },
  {
    item: 'Papan tulis retak',
    room: 'Ruang Kelas X DKV 1',
    major: 'DKV',
    time: '8 Juni, 11.05',
    status: 'Selesai',
    statusClass: 'green',
    image:
      'https://images.unsplash.com/photo-1738308508484-2a5226b4208d?auto=format&fit=crop&w=240&q=80',
  },
]

function BrandMark({ compact = false }: { compact?: boolean }) {
  return (
    <div className={compact ? 'brand brand--compact' : 'brand'}>
      <div className="brand__mark">
        <span />
        <span />
        <span />
      </div>
      <div>
        <strong>RUSAKIN</strong>
        {!compact && <small>Pelaporan Sarana Sekolah</small>}
      </div>
    </div>
  )
}

function Login({ onLogin }: { onLogin: () => void }) {
  const [showPassword, setShowPassword] = useState(false)

  return (
    <main className="login-screen">
      <div className="login-decoration login-decoration--one" />
      <div className="login-decoration login-decoration--two" />
      <section className="login-top">
        <BrandMark />
        <div className="login-illustration" aria-hidden="true">
          <div className="tool-card tool-card--left">!</div>
          <div className="tool-card tool-card--right">
            <CheckIcon size={25} strokeWidth={2.4} />
          </div>
          <div className="phone-art">
            <div className="phone-art__speaker" />
            <div className="phone-art__line phone-art__line--short" />
            <div className="phone-art__line" />
            <div className="phone-art__line" />
            <div className="phone-art__button">+</div>
          </div>
        </div>
      </section>

      <section className="login-panel">
        <div className="eyebrow">Selamat datang</div>
        <h1>Masuk ke akunmu</h1>
        <p>Laporkan kerusakan, bantu sekolah jadi lebih baik.</p>
        <form
          onSubmit={(event) => {
            event.preventDefault()
            onLogin()
          }}
        >
          <label>
            NIS / NIP
            <div className="input-wrap">
              <UserIcon size={19} />
              <input defaultValue="24008127" placeholder="Masukkan NIS atau NIP" required />
            </div>
          </label>
          <label>
            Kata sandi
            <div className="input-wrap">
              <span className="lock-icon">⌁</span>
              <input
                type={showPassword ? 'text' : 'password'}
                defaultValue="sekolah123"
                placeholder="Masukkan kata sandi"
                required
              />
              <button
                className="text-button"
                type="button"
                onClick={() => setShowPassword((value) => !value)}
              >
                {showPassword ? 'Sembunyikan' : 'Lihat'}
              </button>
            </div>
          </label>
          <div className="login-help">
            <label className="remember">
              <input type="checkbox" defaultChecked />
              <span>Ingat saya</span>
            </label>
            <button type="button" className="forgot">
              Lupa kata sandi?
            </button>
          </div>
          <button className="primary-button" type="submit">
            Masuk
            <ArrowIcon size={19} />
          </button>
        </form>
        <p className="login-footer">Akses khusus warga SMK Nusantara</p>
      </section>
    </main>
  )
}

function Home({
  goToReport,
  viewAll,
}: {
  goToReport: () => void
  viewAll: () => void
}) {
  return (
    <>
      <header className="app-header">
        <BrandMark compact />
        <button className="icon-button" aria-label="Notifikasi">
          <BellIcon size={21} />
          <span className="notification-dot" />
        </button>
      </header>
      <div className="screen-content home-content">
        <section className="greeting">
          <div>
            <span>Selamat pagi,</span>
            <h1>Halo, Alya!</h1>
          </div>
          <div className="avatar">AN</div>
        </section>

        <section className="hero-card">
          <div className="hero-card__copy">
            <span className="hero-card__eyebrow">Ada barang rusak?</span>
            <h2>Jangan dibiarkan,<br />segera laporkan.</h2>
            <button onClick={goToReport}>
              Buat laporan
              <ArrowIcon size={17} />
            </button>
          </div>
          <div className="hero-graphic" aria-hidden="true">
            <div className="hero-graphic__paper">
              <span />
              <span />
              <span />
            </div>
            <div className="hero-graphic__check">
              <CheckIcon size={27} strokeWidth={2.5} />
            </div>
          </div>
        </section>

        <section className="stats">
          <div>
            <span className="stats__icon stats__icon--orange">!</span>
            <strong>12</strong>
            <small>Total laporan</small>
          </div>
          <div>
            <span className="stats__icon stats__icon--blue">↻</span>
            <strong>4</strong>
            <small>Sedang diproses</small>
          </div>
          <div>
            <span className="stats__icon stats__icon--green">✓</span>
            <strong>8</strong>
            <small>Telah selesai</small>
          </div>
        </section>

        <section className="report-section">
          <div className="section-heading">
            <div>
              <h2>Sedang diproses</h2>
              <p>Laporan terbaru dari warga sekolah</p>
            </div>
            <button onClick={viewAll}>Lihat semua</button>
          </div>
          <div className="report-list">
            {reports.slice(0, 3).map((report) => (
              <article className="report-card" key={report.item}>
                <img src={report.image} alt="" />
                <div className="report-card__body">
                  <span className={`status status--${report.statusClass}`}>
                    <i />
                    {report.status}
                  </span>
                  <h3>{report.item}</h3>
                  <p>{report.room} · {report.major}</p>
                  <small>{report.time}</small>
                </div>
                <button aria-label={`Lihat ${report.item}`}>
                  <ArrowIcon size={17} />
                </button>
              </article>
            ))}
          </div>
        </section>
      </div>
    </>
  )
}

function AllReports({ onBack }: { onBack: () => void }) {
  const [query, setQuery] = useState('')
  const [filter, setFilter] = useState('Semua')
  const filters = ['Semua', 'Diproses', 'Selesai']
  const visibleReports = reports.filter((report) => {
    const matchesQuery = `${report.item} ${report.room} ${report.major}`
      .toLowerCase()
      .includes(query.toLowerCase())
    const matchesFilter =
      filter === 'Semua' ||
      (filter === 'Selesai'
        ? report.status === 'Selesai'
        : report.status !== 'Selesai')
    return matchesQuery && matchesFilter
  })

  return (
    <>
      <header className="all-reports-header">
        <button onClick={onBack} aria-label="Kembali ke Beranda">
          <BackIcon size={21} />
        </button>
        <div>
          <span>Data pengajuan</span>
          <h1>Semua laporan</h1>
        </div>
        <span className="report-count">{reports.length}</span>
      </header>
      <div className="screen-content all-reports-content">
        <label className="search-box">
          <SearchIcon size={18} />
          <input
            value={query}
            onChange={(event) => setQuery(event.target.value)}
            placeholder="Cari barang atau lokasi..."
          />
        </label>
        <div className="report-filters" aria-label="Filter laporan">
          {filters.map((item) => (
            <button
              key={item}
              className={filter === item ? 'active' : ''}
              onClick={() => setFilter(item)}
            >
              {item}
            </button>
          ))}
        </div>
        <div className="all-reports-summary">
          <div>
            <strong>{visibleReports.length}</strong>
            <span>laporan ditemukan</span>
          </div>
          <small>Diperbarui hari ini</small>
        </div>
        <section className="report-list all-report-list">
          {visibleReports.map((report, index) => (
            <article className="report-card all-report-card" key={report.item}>
              <img src={report.image} alt="" />
              <div className="report-card__body">
                <span className={`status status--${report.statusClass}`}>
                  <i />
                  {report.status}
                </span>
                <h3>{report.item}</h3>
                <p>
                  {report.room} · {report.major}
                </p>
                <small>
                  #{String(index + 1).padStart(3, '0')} · {report.time}
                </small>
              </div>
              <button aria-label={`Lihat ${report.item}`}>
                <ArrowIcon size={17} />
              </button>
            </article>
          ))}
          {visibleReports.length === 0 && (
            <div className="empty-reports">
              <SearchIcon size={24} />
              <strong>Laporan tidak ditemukan</strong>
              <p>Coba gunakan kata kunci atau filter lain.</p>
            </div>
          )}
        </section>
      </div>
    </>
  )
}

function ReportForm({ onSuccess }: { onSuccess: () => void }) {
  const [photo, setPhoto] = useState<string | null>(null)
  const [location, setLocation] = useState('')
  const [customLocation, setCustomLocation] = useState('')

  const onFile = (event: ChangeEvent<HTMLInputElement>) => {
    const file = event.target.files?.[0]
    if (file) setPhoto(URL.createObjectURL(file))
  }

  return (
    <>
      <header className="page-title">
        <span className="page-title__kicker">Formulir pengaduan</span>
        <h1>Kirim laporan baru</h1>
        <p>Isi data kerusakan dengan lengkap dan jelas.</p>
      </header>
      <form
        className="report-form screen-content"
        onSubmit={(event: FormEvent) => {
          event.preventDefault()
          onSuccess()
        }}
      >
        <div className="form-progress">
          <span className="active">1</span>
          <i />
          <span>2</span>
          <p>Detail kerusakan</p>
          <p>Konfirmasi</p>
        </div>

        <label className="field-label">
          Foto barang rusak <em>*</em>
          <span className="field-hint">Pastikan foto terlihat jelas dan tidak buram.</span>
          <label className={`photo-upload ${photo ? 'photo-upload--filled' : ''}`}>
            {photo ? (
              <>
                <img src={photo} alt="Pratinjau barang rusak" />
                <span className="change-photo">Ganti foto</span>
              </>
            ) : (
              <>
                <span className="camera-bubble"><CameraIcon size={25} /></span>
                <strong>Ambil atau unggah foto</strong>
                <small>JPG, PNG · Maks. 5 MB</small>
              </>
            )}
            <input type="file" accept="image/png,image/jpeg" onChange={onFile} />
          </label>
        </label>

        <label className="field-label">
          Nama barang <em>*</em>
          <input required placeholder="Contoh: Proyektor, kursi, kipas..." />
        </label>

        <label className="field-label">
          Lokasi <em>*</em>
          <div className="select-wrap">
            <select
              required
              value={location}
              onChange={(e) => setLocation(e.target.value)}
            >
              <option value="" disabled>Pilih ruang atau kelas</option>
              <option value="Ruang Kelas XI RPL 1">Ruang Kelas XI RPL 1</option>
              <option value="Ruang Kelas XI TKJ 1">Ruang Kelas XI TKJ 1</option>
              <option value="Lab Komputer 1">Lab Komputer 1</option>
              <option value="Perpustakaan">Perpustakaan</option>
              <option value="Lainnya">Lainnya (tulis manual)</option>
            </select>
            <ChevronIcon size={18} />
          </div>
          {location === 'Lainnya' && (
            <input
              className="custom-location"
              required
              placeholder="Tulis lokasi secara manual..."
              value={customLocation}
              onChange={(e) => setCustomLocation(e.target.value)}
            />
          )}
        </label>

        <label className="field-label">
          Jurusan <em>*</em>
          <div className="select-wrap">
            <select required defaultValue="">
              <option value="" disabled>Pilih jurusan</option>
              <option>Rekayasa Perangkat Lunak (RPL)</option>
              <option>Teknik Komputer &amp; Jaringan (TKJ)</option>
              <option>Desain Komunikasi Visual (DKV)</option>
              <option>Umum</option>
            </select>
            <ChevronIcon size={18} />
          </div>
        </label>

        <label className="field-label">
          Keterangan kerusakan <em>*</em>
          <textarea required placeholder="Ceritakan kondisi dan bagian yang rusak..." maxLength={250} />
          <span className="counter">Maks. 250 karakter</span>
        </label>

        <button className="primary-button submit-report" type="submit">
          Lanjutkan
          <ArrowIcon size={19} />
        </button>
      </form>
    </>
  )
}

function Profile({ onLogout }: { onLogout: () => void }) {
  const info = [
    ['NIS', '24008127'],
    ['Kelas', 'XI RPL 1'],
    ['Jurusan', 'Rekayasa Perangkat Lunak'],
    ['Email', 'alya.nuraini@smknusantara.sch.id'],
  ]

  return (
    <>
      <header className="profile-header">
        <span>Akun pengguna</span>
        <h1>Profil saya</h1>
      </header>
      <div className="screen-content profile-content">
        <section className="profile-card">
          <div className="profile-avatar">
            AN
            <button aria-label="Ubah foto profil"><CameraIcon size={15} /></button>
          </div>
          <h2>Alya Nuraini</h2>
          <p>Siswa · Angkatan 2024</p>
          <span className="verified"><CheckIcon size={13} /> Akun terverifikasi</span>
        </section>

        <section className="info-card">
          <div className="section-heading">
            <div><h2>Informasi pribadi</h2></div>
            <button>Edit</button>
          </div>
          {info.map(([label, value]) => (
            <div className="info-row" key={label}>
              <span>{label}</span>
              <strong>{value}</strong>
            </div>
          ))}
        </section>

        <section className="activity-card">
          <h2>Aktivitas laporan</h2>
          <div>
            <span><strong>3</strong>Laporan dibuat</span>
            <span><strong>2</strong>Telah selesai</span>
            <span><strong>1</strong>Dalam proses</span>
          </div>
        </section>

        <button className="logout-button" onClick={onLogout}>
          <LogoutIcon size={20} />
          Keluar dari akun
        </button>
        <small className="version">RUSAKIN versi 1.0.0</small>
      </div>
    </>
  )
}

function BottomNav({ active, setActive }: { active: Tab; setActive: (tab: Screen) => void }) {
  const tabs: { id: Tab; label: string; icon: ReactNode }[] = [
    { id: 'home', label: 'Beranda', icon: <HomeIcon /> },
    { id: 'report', label: 'Kirim aduan', icon: <PlusIcon /> },
    { id: 'profile', label: 'Akun', icon: <UserIcon /> },
  ]

  return (
    <nav className="bottom-nav">
      {tabs.map((tab) => (
        <button
          key={tab.id}
          className={active === tab.id ? 'active' : ''}
          onClick={() => setActive(tab.id)}
        >
          <span>{tab.icon}</span>
          {tab.label}
        </button>
      ))}
    </nav>
  )
}

export default function App() {
  const [loggedIn, setLoggedIn] = useState(false)
  const [activeTab, setActiveTab] = useState<Screen>('home')
  const [success, setSuccess] = useState(false)
  const screen = useMemo(() => {
    if (activeTab === 'home')
      return (
        <Home
          goToReport={() => setActiveTab('report')}
          viewAll={() => setActiveTab('all-reports')}
        />
      )
    if (activeTab === 'all-reports')
      return <AllReports onBack={() => setActiveTab('home')} />
    if (activeTab === 'report') return <ReportForm onSuccess={() => setSuccess(true)} />
    return <Profile onLogout={() => setLoggedIn(false)} />
  }, [activeTab])

  return (
    <div className="app-shell">
      <div className="mobile-app">
        {!loggedIn ? (
          <Login onLogin={() => setLoggedIn(true)} />
        ) : (
          <main className="dashboard">
            <div className="dashboard-scroll">
              {screen}
            </div>
            <BottomNav
              active={activeTab === 'all-reports' ? 'home' : activeTab as Tab}
              setActive={setActiveTab}
            />
            {success && (
              <div className="modal-backdrop" role="dialog" aria-modal="true">
                <div className="success-modal">
                  <div className="success-check"><CheckIcon size={35} strokeWidth={2.5} /></div>
                  <h2>Laporan berhasil dikirim!</h2>
                  <p>Petugas akan memeriksa laporanmu. Pantau statusnya secara berkala di Beranda.</p>
                  <button
                    className="primary-button"
                    onClick={() => {
                      setSuccess(false)
                      setActiveTab('home')
                    }}
                  >
                    Kembali ke Beranda
                  </button>
                </div>
              </div>
            )}
          </main>
        )}
      </div>
    </div>
  )
}

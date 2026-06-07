class PresensiApp {
    constructor() {
        this.currentUser = null;
        this.presensiData = JSON.parse(localStorage.getItem('presensiData')) || this.initData();
        this.init();
    }

    initData() {
        const sampleData = {
            siswa: {
                '123456': {
                    nis: '123456',
                    nama: 'Ahmad Rizky',
                    kelas: 'XII IPA 1',
                    password: '123456'
                },
                '789012': {
                    nis: '789012',
                    nama: 'Siti Nurhaliza',
                    kelas: 'XII IPS 2',
                    password: '789012'
                }
            },
            presensi: {
                '123456': [
                    { tanggal: '2024-01-15', status: 'hadir', waktu: '07:25:00' },
                    { tanggal: '2024-01-16', status: 'telat', waktu: '07:45:00' },
                    { tanggal: '2024-01-17', status: 'alpha', waktu: null }
                ]
            }
        };
        localStorage.setItem('presensiData', JSON.stringify(sampleData));
        return sampleData;
    }

    init() {
        this.bindEvents();
        this.updateTime();
        setInterval(() => this.updateTime(), 1000);
    }

    bindEvents() {
        // Login
        document.getElementById('loginForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleLogin();
        });

        // Navigation
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                this.switchPage(item.dataset.page);
            });
        });

        // Menu toggle
        document.getElementById('menuToggle').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Logout
        document.getElementById('logoutBtn').addEventListener('click', () => {
            this.logout();
        });

        // Presensi
        document.getElementById('presensiBtn').addEventListener('click', () => {
            this.doPresensi();
        });
    }

    handleLogin() {
        const nis = document.getElementById('nis').value;
        const password = document.getElementById('password').value;
        const errorEl = document.getElementById('loginError');

        if (this.presensiData.siswa[nis] && this.presensiData.siswa[nis].password === password) {
            this.currentUser = this.presensiData.siswa[nis];
            this.showDashboard();
            errorEl.textContent = '';
        } else {
            errorEl.textContent = 'NIS atau password salah!';
        }
    }

    showDashboard() {
        document.getElementById('loginPage').classList.remove('active');
        document.getElementById('dashboardPage').classList.add('active');
        
        document.getElementById('userInfo').textContent = `${this.currentUser.nama} (${this.currentUser.kelas})`;
        document.getElementById('sidebarUser').textContent = this.currentUser.nama;
        
        this.loadDashboard();
        this.loadPresensi();
        this.switchPage('dashboard');
    }

    switchPage(page) {
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });
        document.querySelectorAll('.nav-item').forEach(item => {
            item.classList.remove('active');
        });
        
        document.getElementById(page + 'Content').classList.add('active');
        document.querySelector(`[data-page="${page}"]`).classList.add('active');
    }

    loadDashboard() {
        const userPresensi = this.presensiData.presensi[this.currentUser.nis] || [];
        const recent = userPresensi.slice(-5).reverse();

        let hadir = 0, alpha = 0, telat = 0, total = userPresensi.length;
        userPresensi.forEach(p => {
            if (p.status === 'hadir') hadir++;
            else if (p.status === 'telat') telat++;
            else if (p.status === 'alpha') alpha++;
        });

        document.getElementById('totalHadir').textContent = hadir;
        document.getElementById('totalTidakHadir').textContent = alpha;
        document.getElementById('totalTelat').textContent = telat;
        document.getElementById('totalHari').textContent = total;

        const recentHtml = recent.map(p => `
            <div class="activity-item">
                <div class="activity-left">
                    <div class="status-icon icon-${p.status}">
                        <i class="fas fa-${p.status === 'hadir' ? 'check' : p.status === 'telat' ? 'clock' : 'times'}"></i>
                    </div>
                    <div>
                        <div>${new Date(p.tanggal).toLocaleDateString('id-ID', {weekday: 'short', day: 'numeric', month: 'short'})}</div>
                        <div class="status-badge status-${p.status}">${p.status.toUpperCase()}</div>
                    </div>
                </div>
                <div>${p.waktu || '-'}</div>
            </div>
        `).join('');

        document.getElementById('recentPresensi').innerHTML = recentHtml || '<p style="text-align:center;color:#666;padding:40px;">Belum ada data presensi</p>';
    }

    loadPresensi() {
        const today = new Date().toISOString().split('T')[0];
        const userPresensi = this.presensiData.presensi[this.currentUser.nis] || [];
        const todayPresensi = userPresensi.find(p => p.tanggal === today);

        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });

        const statusEl = document.getElementById('presensiStatus');
        const btn = document.getElementById('presensiBtn');

        if (todayPresensi) {
            statusEl.innerHTML = `
                <div class="status-card ${todayPresensi.status}">
                    <i class="fas fa-${todayPresensi.status === 'hadir' ? 'check-circle' : 'clock'}"></i>
                    <h4>${todayPresensi.status === 'hadir' ? 'Presensi Berhasil' : 'Presensi Telat'}</h4>
                    <p>${todayPresensi.waktu}</p>
                    <button class="presensi-btn success">
                        <i class="fas fa-check-circle"></i>
                        Sudah Presensi
                    </button>
                </div>
            `;
        } else {
            statusEl.innerHTML = `
                <div class="status-card waiting">
                    <i class="fas fa-clock"></i>
                    <h4>Belum Presensi</h4>
                    <p>Klik tombol untuk presensi</p>
                    <button class="presensi-btn primary" id="presensiBtn">
                        <i class="fas fa-check"></i>
                        Presensi Sekarang
                    </button>
                </div>
            `;
            // Rebind presensi button
            document.getElementById('presensiBtn').addEventListener('click', () => this.doPresensi());
        }

        this.loadMonthlyPresensi();
    }

    loadMonthlyPresensi() {
        const now = new Date();
        const monthStart = new Date(now.getFullYear(), now.getMonth(), 1);
        const userPresensi = this.presensiData.presensi[this.currentUser.nis] || [];

        const monthly = userPresensi.filter(p => new Date(p.tanggal) >= monthStart);
        
        const html = monthly.map(p => `
            <div class="history-item">
                <div class="history-left">
                    <div class="status-icon icon-${p.status}">
                        <i class="fas fa-${p.status === 'hadir' ? 'check' : p.status === 'telat' ? 'clock' : 'times'}"></i>
                    </div>
                    <div>${new Date(p.tanggal).getDate()} ${new Date(p.tanggal).toLocaleDateString('id-ID', {month: 'short'})}</div>
                </div>
                <span class="status-badge status-${p.status}">${p.status}</span>
            </div>
        `).join('');

        document.getElementById('monthlyPresensi').innerHTML = html || '<p style="text-align:center;color:#666;padding:40px;">Belum ada presensi bulan ini</p>';
    }

    doPresensi() {
        const now = new Date();
        const today = now.toISOString().split('T')[0];
        const waktu = now.toTimeString().split(' ')[0].substring(0, 8);

        const jam = parseInt(waktu.split(':')[0]);
        const menit = parseInt(waktu.split(':')[1]);

        let status = 'hadir';
        if (jam > 7 || (jam === 7 && menit > 30)) {
            status = 'telat';
        }

        if (!this.presensiData.presensi[this.currentUser.nis]) {
            this.presensiData.presensi[this.currentUser.nis] = [];
        }

        this.presensiData.presensi[this.currentUser.nis].push({
            tanggal: today,
            status: status,
            waktu: waktu
        });

        localStorage.setItem('presensiData', JSON.stringify(this.presensiData));
        this.loadPresensi();
        this.loadDashboard();
        
        // Show success message
        alert(`Presensi berhasil! Status: ${status.toUpperCase()}`);
    }

    updateTime() {
        const now = new Date();
        document.getElementById('currentTime').textContent = now.toLocaleTimeString('id-ID');
    }

    logout() {
        this.currentUser = null;
        document.getElementById('dashboardPage').classList.remove('active');
        document.getElementById('loginPage').classList.add('active');
        document.getElementById('loginForm').reset();
        document.getElementById('sidebar').classList.remove('active');
    }
}

// Initialize app
document.addEventListener('DOMContentLoaded', () => {
    new PresensiApp();
});
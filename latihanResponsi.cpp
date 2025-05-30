#include <iostream>
using namespace std;

struct Lagu
{
    string judul;
    string penyanyi;
    string album;
    bool kosong;

    Lagu() : kosong(true) {}
    Lagu(string j, string p, string a) : judul(j), penyanyi(p), album(a), kosong(false) {}

    void tampilkan() const
    {
        cout << "Judul: " << judul << " | Penyanyi: " << penyanyi << " | Album: " << album << endl;
    }
};

struct NodeQueue
{
    Lagu data;
    NodeQueue *next;

    NodeQueue(Lagu lagu) : data(lagu), next(nullptr) {}
};

struct NodeStack
{
    Lagu data;
    NodeStack *next;

    NodeStack(Lagu lagu) : data(lagu), next(nullptr) {}
};

class AntrianLagu
{
private:
    NodeQueue *front;
    NodeQueue *rear;

public:
    AntrianLagu() : front(nullptr), rear(nullptr) {}

    void push(Lagu lagu)
    {
        NodeQueue *newNode = new NodeQueue(lagu);
        if (rear == nullptr)
        {
            front = rear = newNode;
        }
        else
        {
            rear->next = newNode;
            rear = newNode;
        }
    }

    Lagu pop()
    {
        if (front == nullptr)
        {
            return Lagu();
        }

        NodeQueue *temp = front;
        Lagu data = temp->data;
        front = front->next;

        if (front == nullptr)
        {
            rear = nullptr;
        }

        delete temp;
        return data;
    }

    bool empty()
    {
        return front == nullptr;
    }

    void tampilkan()
    {
        if (empty())
        {
            cout << "Antrian kosong!" << endl;
            return;
        }

        cout << "\n=== ANTRIAN LAGU ===" << endl;
        NodeQueue *current = front;
        int no = 1;
        while (current != nullptr)
        {
            cout << no++ << ". ";
            current->data.tampilkan();
            current = current->next;
        }
    }

    ~AntrianLagu()
    {
        while (!empty())
        {
            pop();
        }
    }
};

class RiwayatLagu
{
private:
    NodeStack *top;

public:
    RiwayatLagu() : top(nullptr) {}

    void push(Lagu lagu)
    {
        NodeStack *newNode = new NodeStack(lagu);
        newNode->next = top;
        top = newNode;
    }

    Lagu pop()
    {
        if (top == nullptr)
        {
            return Lagu();
        }

        NodeStack *temp = top;
        Lagu data = temp->data;
        top = top->next;
        delete temp;
        return data;
    }

    Lagu peek()
    {
        if (top == nullptr)
        {
            return Lagu();
        }
        return top->data;
    }

    bool empty()
    {
        return top == nullptr;
    }

    void tampilkan()
    {
        if (empty())
        {
            cout << "Belum ada lagu yang diputar!" << endl;
            return;
        }

        cout << "\n=== RIWAYAT LAGU ===" << endl;
        NodeStack *current = top;
        int no = 1;
        while (current != nullptr)
        {
            cout << no++ << ". ";
            current->data.tampilkan();
            current = current->next;
        }
    }

    ~RiwayatLagu()
    {
        while (!empty())
        {
            pop();
        }
    }
};

class SpotifyKW
{
private:
    static const int MAX_LAGU = 100;
    Lagu daftarLagu[MAX_LAGU];
    int jumlahLagu;
    AntrianLagu antrian;
    RiwayatLagu riwayat;

    void urutkanLagu(Lagu arr[], int n)
    {
        for (int i = 0; i < n - 1; i++)
        {
            for (int j = 0; j < n - i - 1; j++)
            {
                if (arr[j].judul > arr[j + 1].judul)
                {
                    Lagu temp = arr[j];
                    arr[j] = arr[j + 1];
                    arr[j + 1] = temp;
                }
            }
        }
    }

    bool cariSubstring(const string &str, const string &substr)
    {
        if (substr.length() > str.length())
            return false;

        for (size_t i = 0; i <= str.length() - substr.length(); i++)
        {
            bool cocok = true;
            for (size_t j = 0; j < substr.length(); j++)
            {
                if (str[i + j] != substr[j])
                {
                    cocok = false;
                    break;
                }
            }
            if (cocok)
                return true;
        }
        return false;
    }

public:
    SpotifyKW() : jumlahLagu(0) {}

    void tambahLagu(const string &judul, const string &penyanyi, const string &album)
    {
        if (jumlahLagu >= MAX_LAGU)
        {
            cout << "Kapasitas maksimum lagu tercapai!" << endl;
            return;
        }

        daftarLagu[jumlahLagu] = Lagu(judul, penyanyi, album);
        jumlahLagu++;
        cout << "Lagu berhasil ditambahkan: " << judul << endl;
    }

    void cariLagu(const string &judul)
    {
        cout << "\n=== HASIL PENCARIAN ===" << endl;
        bool ditemukan = false;
        for (int i = 0; i < jumlahLagu; i++)
        {
            if (cariSubstring(daftarLagu[i].judul, judul))
            {
                cout << "Index " << (i + 1) << ": ";
                daftarLagu[i].tampilkan();
                ditemukan = true;
            }
        }
        if (!ditemukan)
        {
            cout << "Lagu tidak ditemukan!" << endl;
        }
    }

    void lihatDaftarLagu()
    {
        if (jumlahLagu == 0)
        {
            cout << "Daftar lagu kosong!" << endl;
            return;
        }

        Lagu sortedLagu[MAX_LAGU];
        for (int i = 0; i < jumlahLagu; i++)
        {
            sortedLagu[i] = daftarLagu[i];
        }

        urutkanLagu(sortedLagu, jumlahLagu);

        cout << "\n=== DAFTAR LAGU (A-Z) ===" << endl;
        for (int i = 0; i < jumlahLagu; i++)
        {
            cout << (i + 1) << ". ";
            sortedLagu[i].tampilkan();
        }
    }

    void tambahAntrian(int index)
    {
        if (index >= 1 && index <= jumlahLagu)
        {
            antrian.push(daftarLagu[index - 1]);
            cout << "Lagu ditambahkan ke antrian: " << daftarLagu[index - 1].judul << endl;
        }
        else
        {
            cout << "Index lagu tidak valid!" << endl;
        }
    }

    void putarLagu()
    {
        if (antrian.empty())
        {
            cout << "Antrian lagu kosong! Tambahkan lagu ke antrian terlebih dahulu." << endl;
            return;
        }

        Lagu laguSekarang = antrian.pop();
        if (!laguSekarang.kosong)
        {
            riwayat.push(laguSekarang);

            cout << "\n♪ SEDANG MEMUTAR ♪" << endl;
            cout << "====================\n";
            laguSekarang.tampilkan();
            cout << "====================\n";
        }
    }

    void hapusLagu(int index)
    {
        if (index >= 1 && index <= jumlahLagu)
        {
            cout << "Lagu dihapus: " << daftarLagu[index - 1].judul << endl;

            for (int i = index - 1; i < jumlahLagu - 1; i++)
            {
                daftarLagu[i] = daftarLagu[i + 1];
            }
            jumlahLagu--;
        }
        else
        {
            cout << "Index lagu tidak valid!" << endl;
        }
    }

    void lihatAntrian()
    {
        antrian.tampilkan();
    }

    void lihatRiwayat()
    {
        riwayat.tampilkan();
    }

    void putarLaguTerakhir()
    {
        if (riwayat.empty())
        {
            cout << "Tidak ada lagu di riwayat!" << endl;
            return;
        }

        Lagu laguTerakhir = riwayat.peek();

        cout << "\n♪ MEMUTAR LAGU TERAKHIR ♪" << endl;
        cout << "==========================\n";
        laguTerakhir.tampilkan();
        cout << "==========================\n";
    }

    int getJumlahLagu()
    {
        return jumlahLagu;
    }
};

void tampilkanMenu()
{
    cout << "\n=========== SPOTIFY KW 100 ===========" << endl;
    cout << "1. Tambah Lagu" << endl;
    cout << "2. Cari Lagu" << endl;
    cout << "3. Lihat Daftar Lagu (A-Z)" << endl;
    cout << "4. Tambah Lagu ke Antrian" << endl;
    cout << "5. Putar Lagu" << endl;
    cout << "6. Hapus Lagu" << endl;
    cout << "7. Lihat Antrian" << endl;
    cout << "8. Lihat Riwayat" << endl;
    cout << "9. Putar Lagu Terakhir" << endl;
    cout << "0. Keluar" << endl;
    cout << "=======================================" << endl;
    cout << "Pilih menu: ";
}

int main()
{
    SpotifyKW spotify;
    int pilihan;
    string judul, penyanyi, album;
    int index;

    cout << "Selamat datang di Spotify KW 100!" << endl;

    do
    {
        tampilkanMenu();
        cin >> pilihan;
        cin.ignore();

        switch (pilihan)
        {
        case 1:
            cout << "Masukkan judul lagu: ";
            getline(cin, judul);
            cout << "Masukkan nama penyanyi: ";
            getline(cin, penyanyi);
            cout << "Masukkan nama album: ";
            getline(cin, album);
            spotify.tambahLagu(judul, penyanyi, album);
            break;

        case 2:
            cout << "Masukkan judul lagu yang dicari: ";
            getline(cin, judul);
            spotify.cariLagu(judul);
            break;

        case 3:
            spotify.lihatDaftarLagu();
            break;

        case 4:
            spotify.lihatDaftarLagu();
            cout << "Masukkan index lagu yang ingin ditambahkan ke antrian: ";
            cin >> index;
            spotify.tambahAntrian(index);
            break;

        case 5:
            spotify.putarLagu();
            break;

        case 6:
            spotify.lihatDaftarLagu();
            cout << "Masukkan index lagu yang ingin dihapus: ";
            cin >> index;
            spotify.hapusLagu(index);
            break;

        case 7:
            spotify.lihatAntrian();
            break;

        case 8:
            spotify.lihatRiwayat();
            break;

        case 9:
            spotify.putarLaguTerakhir();
            break;

        case 0:
            cout << "Terima kasih telah menggunakan Spotify KW 100!" << endl;
            break;

        default:
            cout << "Pilihan tidak valid!" << endl;
        }

        if (pilihan != 0)
        {
            cout << "\nTekan Enter untuk melanjutkan...";
            cin.get();
        }

    } while (pilihan != 0);

    return 0;
}
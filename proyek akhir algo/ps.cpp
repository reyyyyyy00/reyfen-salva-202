#include <iostream>
#include <string>
#include <iomanip>
#include <cstdlib>

using namespace std;

const int MAX_QUEUE = 5;
const int HARGA_PER_JAM = 10000;

struct Pelanggan
{
    int no;
    string nama;
    int durasi;
    string konsol;
    int total;
    string waktu;
    Pelanggan *next;
};

struct NodeRiwayat
{
    string nama;
    int durasi;
    string konsol;
    int total;
    NodeRiwayat *next;
};

Pelanggan *front = nullptr;
Pelanggan *rear = nullptr;
int jumlahAntrian = 0;

NodeRiwayat *top = nullptr;
int jumlahRiwayat = 0;

void clearScreen()
{
#ifdef _WIN32
    system("cls");
#else
    system("clear");
#endif
}

void pauseScreen()
{
    cout << "\nTekan Enter untuk melanjutkan...";
    cin.ignore();
    cin.get();
}

void tampilkanHeader()
{
    cout << string(35, '=') << "\n";
    cout << "   SISTEM ANTRIAN RENTAL PS\n";
    cout << string(35, '=') << "\n";
}

void tampilkanMenu()
{
    cout << "1. Tambah Pelanggan\n";
    cout << "2. Periksa Antrian\n";
    cout << "3. Tampilkan Antrian\n";
    cout << "4. Cari Pelanggan\n";
    cout << "5. Urutkan Berdasarkan Durasi\n";
    cout << "6. Layani Pelanggan\n";
    cout << "7. Lihat Riwayat\n";
    cout << "0. Keluar\n";
}

bool isQueueEmpty()
{
    return front == nullptr;
}

bool isQueueFull()
{
    return jumlahAntrian >= MAX_QUEUE;
}

bool enqueue(string nama, int durasi, string konsol)
{
    if (isQueueFull())
    {
        return false;
    }

    Pelanggan *pelangganBaru = new Pelanggan;
    pelangganBaru->no = jumlahAntrian + 1;
    pelangganBaru->nama = nama;
    pelangganBaru->durasi = durasi;
    pelangganBaru->konsol = konsol;
    pelangganBaru->total = durasi * HARGA_PER_JAM;
    pelangganBaru->waktu = "12:00";
    pelangganBaru->next = nullptr;

    if (isQueueEmpty())
    {
        front = rear = pelangganBaru;
    }
    else
    {
        rear->next = pelangganBaru;
        rear = pelangganBaru;
    }

    jumlahAntrian++;
    return true;
}

bool dequeue()
{
    if (isQueueEmpty())
    {
        return false;
    }

    Pelanggan *temp = front;
    front = front->next;

    if (front == nullptr)
    {
        rear = nullptr;
    }

    delete temp;
    jumlahAntrian--;

    Pelanggan *current = front;
    int no = 1;
    while (current != nullptr)
    {
        current->no = no++;
        current = current->next;
    }

    return true;
}

bool isStackEmpty()
{
    return top == nullptr;
}

void pushRiwayat(string nama, int durasi, string konsol, int total)
{
    NodeRiwayat *nodeBaru = new NodeRiwayat;
    nodeBaru->nama = nama;
    nodeBaru->durasi = durasi;
    nodeBaru->konsol = konsol;
    nodeBaru->total = total;
    nodeBaru->next = top;
    top = nodeBaru;
    jumlahRiwayat++;
}

bool popRiwayat()
{
    if (isStackEmpty())
    {
        return false;
    }
    NodeRiwayat *temp = top;
    top = top->next;
    delete temp;
    jumlahRiwayat--;
    return true;
}

void bubbleSortDurasi(bool ascending)
{
    if (isQueueEmpty() || jumlahAntrian <= 1)
    {
        cout << "Tidak ada data untuk diurutkan.\n";
        return;
    }

    Pelanggan *arr[MAX_QUEUE];
    Pelanggan *current = front;
    for (int i = 0; i < jumlahAntrian; i++)
    {
        arr[i] = current;
        current = current->next;
    }

    for (int i = 0; i < jumlahAntrian - 1; i++)
    {
        for (int j = 0; j < jumlahAntrian - i - 1; j++)
        {
            bool tukar = false;

            if (ascending)
            {
                tukar = (arr[j]->durasi > arr[j + 1]->durasi);
            }
            else
            {
                tukar = (arr[j]->durasi < arr[j + 1]->durasi);
            }

            if (tukar)
            {

                string tempNama = arr[j]->nama;
                int tempDurasi = arr[j]->durasi;
                string tempKonsol = arr[j]->konsol;
                int tempTotal = arr[j]->total;
                string tempWaktu = arr[j]->waktu;

                arr[j]->nama = arr[j + 1]->nama;
                arr[j]->durasi = arr[j + 1]->durasi;
                arr[j]->konsol = arr[j + 1]->konsol;
                arr[j]->total = arr[j + 1]->total;
                arr[j]->waktu = arr[j + 1]->waktu;

                arr[j + 1]->nama = tempNama;
                arr[j + 1]->durasi = tempDurasi;
                arr[j + 1]->konsol = tempKonsol;
                arr[j + 1]->total = tempTotal;
                arr[j + 1]->waktu = tempWaktu;
            }
        }
    }

    for (int i = 0; i < jumlahAntrian; i++)
    {
        arr[i]->no = i + 1;
    }

    if (ascending)
    {
        cout << "\nAntrian berhasil diurutkan (durasi terpendek ke terpanjang)\n";
    }
    else
    {
        cout << "\nAntrian berhasil diurutkan (durasi terpanjang ke terpendek)\n";
    }
}

void cariPelanggan(string namaCari)
{
    if (isQueueEmpty())
    {
        cout << "Tidak ada antrian saat ini.\n";
        return;
    }

    for (int i = 0; i < namaCari.length(); i++)
    {
        namaCari[i] = tolower(namaCari[i]);
    }

    Pelanggan *current = front;
    bool ditemukan = false;

    while (current != nullptr)
    {
        string namaSekarang = current->nama;
        for (int i = 0; i < namaSekarang.length(); i++)
        {
            namaSekarang[i] = tolower(namaSekarang[i]);
        }

        if (namaSekarang.find(namaCari) != string::npos)
        {
            cout << "\nPelanggan ditemukan:\n";
            cout << "No. Antrian: " << current->no << "\n";
            cout << "Nama: " << current->nama << "\n";
            cout << "Konsol: " << current->konsol << "\n";
            cout << "Durasi: " << current->durasi << " jam\n";
            cout << "Total: Rp " << current->total << "\n";
            cout << "Waktu daftar: " << current->waktu << "\n";
            ditemukan = true;
            break;
        }
        current = current->next;
    }

    if (!ditemukan)
    {
        cout << "Pelanggan tidak ditemukan dalam antrian.\n";
    }
}

void tampilkanAntrian()
{
    if (isQueueEmpty())
    {
        cout << "Tidak ada antrian saat ini.\n";
        return;
    }

    cout << "\n=== DAFTAR ANTRIAN ===\n";
    cout << left << setw(3) << "No" << setw(15) << "Nama" << setw(8) << "Konsol"
         << setw(8) << "Durasi" << setw(12) << "Total" << "Waktu\n";
    cout << string(55, '-') << "\n";

    Pelanggan *current = front;
    while (current != nullptr)
    {
        cout << left << setw(3) << current->no
             << setw(15) << current->nama
             << setw(8) << current->konsol
             << setw(8) << (to_string(current->durasi) + " jam")
             << "Rp " << setw(8) << current->total
             << current->waktu << "\n";
        current = current->next;
    }
}

void tampilkanRiwayat()
{
    if (isStackEmpty())
    {
        cout << "Belum ada riwayat pelanggan.\n";
        return;
    }

    cout << "\n=== RIWAYAT PELANGGAN (5 TERAKHIR) ===\n";
    cout << left << setw(15) << "Nama" << setw(8) << "Konsol"
         << setw(8) << "Durasi" << "Total\n";
    cout << string(40, '-') << "\n";

    NodeRiwayat *current = top;
    int tampil = 0;
    while (current != nullptr && tampil < 5)
    {
        cout << left << setw(15) << current->nama
             << setw(8) << current->konsol
             << setw(8) << (to_string(current->durasi) + " jam")
             << "Rp " << current->total << "\n";
        current = current->next;
        tampil++;
    }
}

void tambahPelanggan()
{
    if (isQueueFull())
    {
        cout << "\nMaaf! Antrian sudah penuh (maksimal " << MAX_QUEUE << " pelanggan)\n";
        cout << "Silakan coba lagi nanti.\n";
        return;
    }

    cout << "\n=== TAMBAH PELANGGAN BARU ===\n";
    string nama, konsol;
    int durasi;

    cout << "Nama pelanggan: ";
    cin.ignore();
    getline(cin, nama);

    if (nama.empty())
    {
        cout << "Nama tidak boleh kosong!\n";
        return;
    }

    cout << "Durasi bermain (jam): ";
    cin >> durasi;

    if (durasi <= 0)
    {
        cout << "Durasi harus lebih dari 0!\n";
        return;
    }

    cout << "Jenis konsol (PS4/PS5): ";
    cin >> konsol;

    if (konsol != "PS4" && konsol != "PS5")
    {
        konsol = "PS4";
    }

    if (enqueue(nama, durasi, konsol))
    {
        cout << "\nPelanggan berhasil ditambahkan!\n";
        cout << "Total biaya: Rp " << (durasi * HARGA_PER_JAM) << "\n";
    }
    else
    {
        cout << "Gagal menambahkan pelanggan!\n";
    }
}

void periksaAntrian()
{
    cout << "\n=== PERIKSA ANTRIAN ===\n";
    if (isQueueEmpty())
    {
        cout << "Tidak ada antrian saat ini.\n";
    }
    else
    {
        cout << "Jumlah antrian: " << jumlahAntrian << " pelanggan\n";
        cout << "Sisa slot: " << (MAX_QUEUE - jumlahAntrian) << " slot\n";

        if (front != nullptr)
        {
            cout << "\nPelanggan berikutnya:\n";
            cout << "Nama: " << front->nama << "\n";
            cout << "Konsol: " << front->konsol << "\n";
            cout << "Durasi: " << front->durasi << " jam\n";
            cout << "Total: Rp " << front->total << "\n";
        }
    }
}

void layaniPelanggan()
{
    if (isQueueEmpty())
    {
        cout << "\nTidak ada pelanggan dalam antrian.\n";
        return;
    }

    cout << "\n=== MELAYANI PELANGGAN ===\n";
    cout << "Melayani: " << front->nama << "\n";
    cout << "Konsol: " << front->konsol << "\n";
    cout << "Durasi: " << front->durasi << " jam\n";
    cout << "Total: Rp " << front->total << "\n";

    pushRiwayat(front->nama, front->durasi, front->konsol, front->total);

    dequeue();
    cout << "\nPelanggan berhasil dilayani dan dihapus dari antrian.\n";
}

void urutkanDurasi()
{
    cout << "\n=== URUTKAN BERDASARKAN DURASI ===\n";
    if (isQueueEmpty())
    {
        cout << "Tidak ada antrian untuk diurutkan.\n";
        return;
    }

    cout << "1. Urutkan durasi terpendek ke terpanjang\n";
    cout << "2. Urutkan durasi terpanjang ke terpendek\n";

    int pilihan;
    cout << "Pilihan (1/2): ";
    cin >> pilihan;

    if (pilihan == 1)
    {
        bubbleSortDurasi(true);
    }
    else if (pilihan == 2)
    {
        bubbleSortDurasi(false);
    }
    else
    {
        cout << "Pilihan tidak valid!\n";
    }
}

int main()
{
    int pilihan;

    do
    {
        clearScreen();
        tampilkanHeader();
        tampilkanMenu();

        cout << "\nPilihan: ";
        cin >> pilihan;

        switch (pilihan)
        {
        case 1:
            tambahPelanggan();
            break;
        case 2:
            periksaAntrian();
            break;
        case 3:
            tampilkanAntrian();
            break;
        case 4:
        {
            string nama;
            cout << "\nMasukkan nama pelanggan: ";
            cin.ignore();
            getline(cin, nama);
            cariPelanggan(nama);
            break;
        }
        case 5:
            urutkanDurasi();
            break;
        case 6:
            layaniPelanggan();
            break;
        case 7:
            tampilkanRiwayat();
            break;
        case 0:
            cout << "\nTerima kasih telah menggunakan sistem rental PS!\n";
            cout << "Sampai jumpa!\n";
            break;
        default:
            cout << "Pilihan tidak valid!\n";
        }

        if (pilihan != 0)
        {
            pauseScreen();
        }

    } while (pilihan != 0);

    while (!isQueueEmpty())
    {
        dequeue();
    }
    while (!isStackEmpty())
    {
        popRiwayat();
    }

    return 0;
}
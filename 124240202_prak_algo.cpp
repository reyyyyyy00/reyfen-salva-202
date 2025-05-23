#include <iostream>
using namespace std;

struct Pesanan
{
    char nama[50];
    char jenisRoti[50];
    double totalHarga;
    Pesanan *next;
};

Pesanan *front = NULL;
Pesanan *rear = NULL;
Pesanan *riwayatHead = NULL;

void ambilAntrean()
{
    Pesanan *baru = new Pesanan;
    cout << "Nama Pembeli (1 kata): ";
    cin >> baru->nama;
    cout << "Jenis Roti (1 kata): ";
    cin >> baru->jenisRoti;
    cout << "Total Harga: ";
    cin >> baru->totalHarga;
    baru->next = NULL;

    if (rear == NULL)
    {
        front = rear = baru;
    }
    else
    {
        rear->next = baru;
        rear = baru;
    }
    cout << "Pesanan ditambahkan ke antrean.\n";
}
void layaniPembeli()
{
    if (front == NULL)
    {
        cout << "Antrean kosong.\n";
        return;
    }

    Pesanan *dilayani = front;
    front = front->next;
    if (front == NULL)
        rear = NULL;

    dilayani->next = riwayatHead;
    riwayatHead = dilayani;

    cout << "Pesanan atas nama " << dilayani->nama << " telah dilayani.\n";
}

void tampilkanAntrean()
{
    if (front == NULL)
    {
        cout << "Antrean kosong.\n";
        return;
    }
    Pesanan *temp = front;
    int no = 1;
    cout << "Daftar Antrean:\n";
    while (temp != NULL)
    {
        cout << no++ << ". " << temp->nama << " - " << temp->jenisRoti << " - Rp" << temp->totalHarga << endl;
        temp = temp->next;
    }
}

void batalkanPesanan()
{
    if (front == NULL)
    {
        cout << "Antrean kosong, tidak ada yang bisa dibatalkan.\n";
        return;
    }
    if (front == rear)
    {
        cout << "Pesanan " << rear->nama << " dibatalkan.\n";
        delete rear;
        front = rear = NULL;
        return;
    }

    Pesanan *temp = front;
    while (temp->next != rear)
    {
        temp = temp->next;
    }
    cout << "Pesanan " << rear->nama << " dibatalkan.\n";
    delete rear;
    rear = temp;
    rear->next = NULL;
}

void tampilkanRiwayat()
{
    if (riwayatHead == NULL)
    {
        cout << "Belum ada pesanan yang dilayani.\n";
        return;
    }
    Pesanan *temp = riwayatHead;
    int no = 1;
    cout << "Riwayat Pesanan yang Telah Dilayani:\n";
    while (temp != NULL)
    {
        cout << no++ << ". " << temp->nama << " - " << temp->jenisRoti << " - Rp" << temp->totalHarga << endl;
        temp = temp->next;
    }
}

void bersihkanSemua()
{
    while (front != NULL)
    {
        Pesanan *hapus = front;
        front = front->next;
        delete hapus;
    }
    while (riwayatHead != NULL)
    {
        Pesanan *hapus = riwayatHead;
        riwayatHead = riwayatHead->next;
        delete hapus;
    }
}

int main()
{
    int pilihan;

    do
    {
        cout << "\n=== Sistem Antrean Toko Roti Manis Lezat ===\n";
        cout << "1. Ambil Antrean\n";
        cout << "2. Layani Pembeli\n";
        cout << "3. Tampilkan Antrean\n";
        cout << "4. Batalkan Pesanan Terakhir\n";
        cout << "5. Tampilkan Riwayat\n";
        cout << "0. Keluar\n";
        cout << "Pilih menu: ";
        cin >> pilihan;

        switch (pilihan)
        {
        case 1:
            ambilAntrean();
            break;
        case 2:
            layaniPembeli();
            break;
        case 3:
            tampilkanAntrean();
            break;
        case 4:
            batalkanPesanan();
            break;
        case 5:
            tampilkanRiwayat();
            break;
        case 0:
            bersihkanSemua();
            cout << "Terima kasih!\n";
            break;
        default:
            cout << "Pilihan tidak valid.\n";
        }
    } while (pilihan != 0);

    return 0;
}

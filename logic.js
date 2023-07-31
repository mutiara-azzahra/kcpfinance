// Tabel stok
const tabelStok = [
    {
        id: 123, // id tabel stok, biasanya auto increment
        idBarang: 1,
        stok: 10,
        harga: 10000,
        index: 1,
        terjual: 0
    },
    {
        id: 124, // id tabel stok, biasanya auto increment
        idBarang: 1,
        stok: 5,
        harga: 12000,
        index: 2,
        terjual: 0
    },
]


// Rumus pembelian
function usePembelian(idBarang, totalBeli, hargaBeli) {
    // Cari list barang dengan idBarang, kemudian sortir berdasarkan index tertinggi
    const listBarang = tabelStok.filter(dataStok => dataStok.idBarang === idBarang)
        .sort((a, b) => b.index - a.index)
    
    const dataBarang = listBarang[0] // Ambil barang dengan index tertinggi

    const indexBaru = dataBarang
      ? dataBarang.index + 1 // Kalau ada dataBarang maka ambil index dataBarang + 1
        : 1 // Kalau tidak ada atur index jadi 1
    
    // Menambah pembelian ke tabel stok
    tabelStok.push({
        id: 124, // id tabel stok, biasanya auto increment
        idBarang: idBarang,
        harga: hargaBeli,
        stok: totalBeli
    });
}

function updatestokbarang(idBarang, stok) {
}

// Rumus penjualan
function usePenjualan(idBarang, totalJual = 8) {
    // Cari list barang dengan idBarang dan stok > 0, kemudian sortir berdasarkan index terendah (FIFO)
    const listBarang = tabelStok.filter(dataStok => dataStok.idBarang === idBarang && dataStok.stok > 0)
        .sort((a, b) => a.index - b.index)
    
    const dataBarang = listBarang[0] // Ambil barang dengan index terendah (FIFO)

    let sisaBarangYangDijual = totalJual

    for (sisaBarangYangDijual > 0) {
        if (dataBarang.stok > sisaBarangYangDijual) {
            dataBarang.stok = dataBarang.stok - sisaBarangYangDijual
            //update data stok
        } else {
            sisaBarangYangDijual=sisaBarangYangDijual-dataBarang.stok
            dataBarang.stok = 0
            //update data stok

            // looping sampe habis total jual
            usePenjualan(idBarang,sisaBarangYangDijual)
        
        }
    });
}
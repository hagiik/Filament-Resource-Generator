<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Penjelasan tentang Resources -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Resources</h2>
            <p class="text-gray-500 dark:text-gray-300">
                <strong>Resources</strong> adalah komponen utama di sistem ini yang digunakan untuk mengelola data (CRUD). Setiap Resource yang Anda buat akan otomatis terhubung dengan:
            </p>
            <ul class="list-disc list-inside mt-2 text-gray-600 dark:text-gray-400">
                <li class="py-2"><strong>Model</strong>: Representasi tabel database.</li>
                <li class="py-2"><strong>Migration</strong>: File untuk membuat atau memodifikasi tabel database.</li>
                <li class="py-2"><strong>Filament Resource</strong>: Halaman admin untuk mengelola data.</li>
            </ul>
            <p class="mt-4 text-gray-500 dark:text-gray-300">
                Contoh: Jika Anda membuat Resource dengan nama <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">Product</code>, sistem akan membuat:
            </p>
            <ul class="list-disc list-inside mt-2 text-gray-600 dark:text-gray-400">
                <li class="py-2">Model: <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">Product.php</code></li>
                <li class="py-2">Migration: <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">create_products_table.php</code></li>
                <li class="py-2">Filament Resource: <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">ProductResource.php</code></li>
            </ul>
        </div>

        <!-- Penjelasan tentang Fields -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Fields</h2>
            <p class="text-gray-500 dark:text-gray-300">
                <strong>Fields</strong> adalah kolom-kolom yang akan ditambahkan ke dalam tabel database. Setiap Field memiliki:
            </p>
            <ul class="list-disc list-inside mt-2 text-gray-600 dark:text-gray-400">
                <li class="py-2"><strong>Nama</strong>: Nama kolom di database.</li>
                <li class="py-2"><strong>Tipe</strong>: Jenis data yang disimpan (contoh: string, integer, date).</li>
                <li class="py-2"><strong>Opsi</strong>: Beberapa opsi yang dapat dikonfigurasi untuk setiap field:</li>
                <ul class="list-disc list-inside pl-6">
                    <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">nullable</code>: Kolom boleh kosong.</li>
                    <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">unique</code>: Nilai kolom harus unik.</li>
                    <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">default</code>: Nilai default untuk kolom.</li>
                    <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">comment</code>: Komentar untuk kolom.</li>
                    <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">unsigned</code>: Kolom numerik tanpa tanda (unsigned).</li>
                    <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">autoIncrement</code>: Kolom auto-increment (biasanya untuk primary key).</li>
                    <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">index</code>: Tambahkan indeks ke kolom.</li>
                    <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">fulltext</code>: Tambahkan indeks fulltext ke kolom (hanya untuk tipe text).</li>
                    <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">useCurrent</code>: Gunakan waktu saat ini sebagai nilai default (untuk tipe timestamp).</li>
                    <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">useCurrentOnUpdate</code>: Gunakan waktu saat ini saat kolom diperbarui (untuk tipe timestamp).</li>
                </ul>
            </ul>
            <p class="mt-4 text-gray-500 dark:text-gray-300">
                Untuk Penjelasan secara detail bisa cek dokumentasi <a href="https://laravel.com/docs/12.x/migrations#available-column-types"> <code class="bg-primary-600 dark:bg-success-600  text-white dark:text-gray-200 px-2 py-1 rounded">Laravel</code></a> 
            </p>
            <p class="mt-4 text-gray-500 dark:text-gray-300">
                Contoh: Field <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">name</code> dengan tipe <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">string</code> akan menghasilkan kolom <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">name</code> di tabel database.
            </p>
        </div>

        <!-- Penjelasan tentang Relations -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Relations</h2>
            <p class="text-gray-500 dark:text-gray-300">
                <strong>Relations</strong> digunakan untuk menghubungkan satu Model dengan Model lainnya. Jenis relasi yang didukung:
            </p>
            <ul class="list-disc list-inside mt-2 text-gray-600 dark:text-gray-400">
                <li class="py-2"><strong>BelongsTo</strong>: Hubungan satu-ke-satu (contoh: Produk milik satu Kategori).</li>
                <li class="py-2"><strong>HasMany</strong>: Hubungan satu-ke-banyak (contoh: Kategori memiliki banyak Produk).</li>
                <li class="py-2"><strong>ManyToMany</strong>: Hubungan banyak-ke-banyak (contoh: Produk memiliki banyak Tag, dan Tag dimiliki oleh banyak Produk).</li>
            </ul>
            <p class="py-2 text-gray-500 dark:text-gray-300">
                Contoh: Jika Anda menambahkan relasi <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">belongsTo</code> antara <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">Product</code> dan <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">Category</code>, sistem akan menambahkan kolom <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">category_id</code> di tabel <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">products</code>.
            </p>
        </div>

        <!-- Penjelasan tentang Shield Permissions -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Shield Permissions</h2>
            <p class="text-gray-500 dark:text-gray-300">
                Setiap Resource yang dibuat akan otomatis dilengkapi dengan <strong>permissions</strong> yang di-generate menggunakan Laravel Shield. Ini memungkinkan Anda mengontrol akses ke Resource berdasarkan role pengguna.
            </p>
            <p class="mt-4 text-gray-500 dark:text-gray-300">
                Contoh: Jika Anda membuat Resource <code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">Product</code>, Shield akan membuat permissions seperti:
            </p>
            <ul class="list-disc list-inside mt-2 text-gray-600 dark:text-gray-400">
                <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">view_product</code>: Izin untuk melihat data produk.</li>
                <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">create_product</code>: Izin untuk membuat data produk.</li>
                <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">update_product</code>: Izin untuk memperbarui data produk.</li>
                <li class="py-2"><code class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">delete_product</code>: Izin untuk menghapus data produk.</li>
            </ul>
        </div>
    </div>
</x-filament-panels::page>
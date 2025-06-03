<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <h1 class="text-4xl font-bold text-slate-500">Histori</h1>
  <div class="flex flex-col bg-white p-5 rounded mt-4 shadow-lg">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
              <tr>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Id</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Waktu</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Paket Foto</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Total</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Status</th>
                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($bookings as $booking)
              <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $booking->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($booking->tanggal)->format('d-m-Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($booking->waktu)->format('H:i') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                  @foreach($booking->detail as $detail)
                    <div>{{ $detail->paketFoto->nama_paket_foto }}</div>
                  @endforeach
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">Rp {{ number_format($booking->total, 0, ',', '.') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                  @if($booking->status_pembayaran === 'pending')
                    <span class="bg-yellow-500 py-1 px-3 rounded text-white shadow">Menunggu</span>
                  @elseif($booking->status_pembayaran === 'approved')
                    <span class="bg-green-500 py-1 px-3 rounded text-white shadow">Disetujui</span>
                  @elseif($booking->status_pembayaran === 'rejected')
                    <span class="bg-red-500 py-1 px-3 rounded text-white shadow">Ditolak</span>
                  @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                  @if($booking->status_pembayaran === 'pending' && !$booking->bukti_pembayaran)
                    <a href="{{ route('upload.bukti.pembayaran', $booking->id) }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Upload Bukti</a>
                  @elseif($booking->status_pembayaran === 'approved')
                    <a href="{{ route('booking.success', $booking->id) }}" class="bg-slate-600 text-white py-2 px-4 rounded-md hover:bg-slate-500">Lihat Details</a>
                  @else
                    <a href="{{ route('booking.success', $booking->id) }}" class="bg-slate-600 text-white py-2 px-4 rounded-md hover:bg-slate-500">Lihat Details</a>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data reservasi</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
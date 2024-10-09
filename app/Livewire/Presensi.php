<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Leave;
use Auth;
use Carbon\Carbon;

class Presensi extends Component
{
    public $latitude;
    public $longitude;
    public $insideRadius = false;

    public function render()
    {
        $schedule = Schedule::where('user_id', Auth::user()->id)->first();
        $attendance = Attendance::where('user_id', Auth::user()->id)
            ->whereDate('created_at', date('Y-m-d'))->first();
        return view('livewire.presensi', [
            'schedule' => $schedule,
            'insideRadius' => $this->insideRadius,
            'attendance' => $attendance,
        ]);
    }

    public function store()
    {
        $this->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $schedule = Schedule::where('user_id', Auth::user()->id)->first();

        // Cek jika sedang cuti
        $today = Carbon::today()->format('Y-m-d');
        $approveLeave = Leave::where('user_id', Auth::user()->id)
            ->where('status', 'approve')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->exists();

        if ($approveLeave) {
            session()->flash('error', 'Anda sedang cuti');
            return;
        }

        if ($schedule) {
            $attendance = Attendance::where('user_id', Auth::user()->id)
                ->whereDate('created_at', date('Y-m-d'))->first();

            if (!$attendance) {
                // Presensi masuk
                Attendance::create([
                    'user_id' => Auth::user()->id,
                    'schedule_latitude' => $schedule->office->latitude,
                    'schedule_longitude' => $schedule->office->longitude,
                    'schedule_waktu_datang' => $schedule->shift->waktu_datang,
                    'schedule_waktu_pulang' => $schedule->shift->waktu_pulang,
                    'datang_latitude' => $this->latitude,
                    'datang_longitude' => $this->longitude,
                    'waktu_datang' => Carbon::now()->toTimeString(),
                    // Tidak perlu menyertakan waktu_pulang di sini
                ]);
                session()->flash('message', 'Presensi masuk berhasil.');
            } else {
                // Presensi pulang
                if ($attendance->waktu_pulang) {
                    session()->flash('error', 'Anda sudah melakukan presensi pulang hari ini.');
                    return;
                }
                $attendance->update([
                    'pulang_latitude' => $this->latitude,
                    'pulang_longitude' => $this->longitude,
                    'waktu_pulang' => Carbon::now()->toTimeString(),
                ]);
                session()->flash('message', 'Presensi pulang berhasil.');
            }

            return redirect('admin/attendances');
        }
    }
}
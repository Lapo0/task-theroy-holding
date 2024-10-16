<?php

if (!function_exists('format_last_activity')) {
    function format_last_activity($timestamp)
    {
        if (is_null($timestamp)) {
            return 'Mai attivo'; // Messaggio predefinito se non ci sono dati di accesso
        }

        $now = \Carbon\Carbon::now();
        $lastActivity = \Carbon\Carbon::createFromTimestamp($timestamp);
        
        $diffInMinutes = $lastActivity->diffInMinutes($now);
        $diffInHours = $lastActivity->diffInHours($now);
        $diffInDays = $lastActivity->diffInDays($now);

        if ($diffInMinutes < 1) {
            return 'Attivo ora';
        } elseif ($diffInMinutes < 60) {
            return "Attivo $diffInMinutes minuti fa";
        } elseif ($diffInHours < 24) {
            return "Attivo $diffInHours ore fa";
        } elseif ($diffInDays < 30) {
            return "Attivo $diffInDays giorni fa";
        } else {
            return $lastActivity->format('d M Y'); // Formato data personalizzato
        }
    }
}

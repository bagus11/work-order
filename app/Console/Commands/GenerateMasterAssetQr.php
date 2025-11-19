<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MasterAsset;
use Illuminate\Support\Facades\Storage;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class GenerateMasterAssetQr extends Command
{
    protected $signature = 'master-asset:generate-qr {--force : Regenerate all QR codes even if already exists}';
    protected $description = 'Generate QR codes for all MasterAsset records without using imagick';

    public function handle()
    {
        $assets = MasterAsset::where('type', 1)->get();
        $this->info("Found {$assets->count()} assets.");

        foreach ($assets as $asset) {
            // if ($asset->qr_code && !$this->option('force')) {
            //     $this->line("⏭️ Skipping asset ID {$asset->id} (QR exists)");
            //     continue;
            // }

            // Data QR
            $data = [
                'id' => $asset->id,
                'product_code' => $asset->product_code,
                'product_name' => $asset->product_name,
                'url' => route('master-assets.show', $asset->id),
            ];

            $json = json_encode($data);

            // Renderer tanpa imagick → pakai SVG
            $renderer = new ImageRenderer(
                new RendererStyle(300),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);
            $qrSvg = $writer->writeString($json);

            // Simpan sebagai file SVG
            $directory = 'qr_asset';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            $fileName = 'qr_' . $asset->id . '.svg';
            $filePath = $directory . '/' . $fileName;
            Storage::put($filePath, $qrSvg);

            // Simpan path ke DB
            $asset->qr_code = 'storage/qr_asset/' . $fileName;
            $asset->save();

            $this->line("✅ Generated QR (SVG) for asset ID {$asset->id}");
        }

        $this->info('All QR codes generated successfully — no Imagick needed!');
    }
}

<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <a href="{{ request()->url() }}">
                <i class="fas fa-bus me-2"></i>
                {{ $terminal ? 'ویرایش پایانه' : 'ایجاد پایانه جدید' }}
            </a>
        </h2>
        <a href="{{ route('terminals.index') }}" class="btn btn-outline-secondary" wire:navigate>
            <i class="fas fa-arrow-right me-2"></i>
            بازگشت
        </a>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-body">
            <form wire:submit="save">
                <!-- Name - Full width -->
                <div class="row mb-4">
                    <div class="col-12">
                        <x-forms.input
                            name="name"
                            label="نام پایانه"
                            wire:model="name"
                            required
                        />
                    </div>
                </div>

                <!-- Province & County -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <x-forms.input
                            input-type="select"
                            name="province_id"
                            label="استان"
                            :options="$provinces"
                            wire:model.live="province_id"
                            required
                        />
                    </div>
                    <div class="col-md-6">
                        <x-forms.input
                            input-type="select"
                            name="county_id"
                            label="شهرستان"
                            :options="$counties"
                            wire:model.live="county_id"
                            :disabled="!$province_id"
                            required
                        />
                    </div>
                </div>

                <!-- District & Settlement -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <x-forms.input
                            input-type="select"
                            name="district_id"
                            label="بخش"
                            :options="$districts"
                            wire:model.live="district_id"
                            :disabled="!$county_id"
                            required
                        />
                    </div>
                    <div class="col-md-6">
                        <x-forms.input
                            input-type="select"
                            name="settlement_id"
                            label="دهستان/شهر"
                            :options="$settlements"
                            wire:model.live="settlement_id"
                            :disabled="!$district_id"
                            required
                        />
                    </div>
                </div>

                <!-- Village - Full width -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <x-forms.input
                            input-type="select"
                            name="village_id"
                            label="روستا (اختیاری)"
                            :options="$villages"
                            wire:model="village_id"
                            :disabled="!$settlement_id"
                        />
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        {{ $terminal ? 'ذخیره تغییرات' : 'ذخیره' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

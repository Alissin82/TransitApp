<x-layouts.app-content>
    <x-common.page-breadcrumb :pageTitle="$terminal ? model_trans('terminal', 'edit') : model_trans('terminal', 'create')" />

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">

        {{-- Card Header --}}
        <div class="px-6 py-5">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                {{ __('terminal.singular') }}
            </h3>
        </div>

        {{-- Card Body --}}
        <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">

            <form wire:submit.prevent="save">
                <div class="-mx-2.5 flex flex-wrap gap-y-5">

                    <x-forms.text
                            name="name"
                            label="{{ __('terminal.fields.name') }}"
                            wire:model="name"
                    />

                    <x-forms.select
                            name="province_id"
                            label="{{ __('Province') }}"
                            placeholder="{{ __('Select Province') }}"
                            :options="$provinces"
                            :selected="(bool) $province_id"
                            width="half"
                            wire:model.live="province_id"
                    />

                    <x-forms.select
                            name="county_id"
                            label="{{ __('County') }}"
                            placeholder="{{ __('Select County') }}"
                            :options="$counties"
                            :selected="(bool) $county_id"
                            width="half"
                            wire:model.live="county_id"
                            :disabled="!$province_id"
                    />

                    <x-forms.select
                            name="district_id"
                            label="{{ __('District') }}"
                            placeholder="{{ __('Select District') }}"
                            :options="$districts"
                            :selected="(bool) $district_id"
                            width="half"
                            wire:model.live="district_id"
                            :disabled="!$county_id"
                    />

                    <x-forms.select
                            name="settlement_id"
                            label="{{ __('Settlement') }}"
                            placeholder="{{ __('Select Settlement') }}"
                            :options="$settlements"
                            :selected="(bool) $settlement_id"
                            width="half"
                            wire:model.live="settlement_id"
                            :disabled="!$district_id"
                    />

                    <x-forms.select
                            name="village_id"
                            label="{{ __('Village') }}"
                            hint="{{ __('Optional') }}"
                            placeholder="{{ __('Select Village') }}"
                            :options="$villages"
                            width="half"
                            wire:model="village_id"
                            :disabled="!$settlement_id"
                    />

                    {{-- Actions --}}
                    <div class="w-full px-2.5">
                        <div class="mt-1 flex items-center gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">

                            <x-ui.button type="submit">
                                {{ $terminal ? __('Save changes') : __('Save') }}
                            </x-ui.button>

                            <x-tables.button href="{{ route('terminals.index') }}" wire:navigate>
                                {{ __('Cancel') }}
                            </x-tables.button>

                        </div>
                    </div>

                </div>
            </form>

        </div>

    </div>
</x-layouts.app-content>

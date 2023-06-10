<!-- We will use an inline Alpine.js component and again, use x-ref so we can use multiple components 
     on the same page -->
     <div class="border-dashed bg-white border-2 rounded-md p-1" wire:ignore x-data="state()"  x-on:clear-upload.window="clearUpload">
        <div>
            <input type="file" x-ref="filepond" {{ $attributes->whereDoesntStartWith('wire:model')->except(['id']) }}>
        </div>
    </div>
    
    @once
        @push('styles')
            @vite(['resources/css/components/filepond.css'])
        @endpush
        @push('scripts')
            @vite(['resources/js/components/filepond.js'])
            <script>
                function state() {
                    return {
                        pond: {},
                        init() {
    // We create the component and specify that it will not allow multiple file uploads
                            this.pond = window.FilePond.create(this.$refs.filepond, {
                                allowMultiple: false,
                                acceptedFileTypes: ['image/png', 'image/jpeg'],
                                maxFileSize: '4MB',
                            });
    // We set the server Filepond options to work with Livewire using inline scripts to
    // access the component from Javascript (see: https://laravel-livewire.com/docs/2.x/inline-scripts).
    // We then use the process and revert Filepond API to support upload progress and remove upload
    // The documentation for these options can be found here: https://pqina.nl/filepond/docs/api/server/#process
                            this.pond.setOptions({
                                server: {
                                    process: (fieldName, file, metadata, load, error, progess, abort, transfer,
                                    options) => {
                                        @this.upload('{{ $attributes->wire('model')->value() }}', file, load, error,
                                            progess);
                                    },
                                    revert: (filename, load) => {
                                        @this.removeUpload('{{ $attributes->wire('model')->value() }}', filename, load);
                                    },
                                },
                            })
                        },
                        clearUpload() {
                            this.pond.removeFile();
                        },
                    }
                }
            </script>
        @endpush
    @endonce
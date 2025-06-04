<div class="container-fluid px-4" xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="row mt-2 p-6 bg-white rounded-lg shadow ">
        <div class="card">
            <div class="page-header card mt-3 mb-3 shadow-sm border-1">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="mb-0 me-3 text-primary">
                            <i class="fa fa-box-open me-2 text-secondary"></i>
                            Produtos
                        </h5>
                        <ul class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Cadastro de Produto
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div wire:loading.class="opacity-50">
                <div class="card mb-2 p-2">
                    <form wire:submit.prevent="salvar">
                        <div class="row">
                            <!-- Dados Básicos -->
                            <div class="col-md-2">
                                <label class="form-label-custom">Código do Produto(Sku)</label>
                                <input type="text" wire:model="produto.sku" class="form-control">
                                @error('produto.sku') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label-custom">Código de Barras</label>
                                <input type="text" wire:model="produto.codigo_barras" class="form-control">
                                @error('produto.codigo_barras') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label-custom">Nome do Produto</label>
                                <input type="text" wire:model="produto.nome" class="form-control">
                                @error('produto.nome') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- Variações -->
                            <div class="col-md-1" wire:ignore>
                                <label class="form-label-custom">Formato</label>
                                <select onchange="@this.call('temVariacao', this.value)" class="form-control">
                                    <option value="0">Sem Variação</option>
                                    <option value="1">Com Variação</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <label class="form-label-custom">Quantidade</label>
                                <input type="number" wire:model="produto.quantidade" class="form-control">
                                @error('produto.Quantidade') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-1">
                                <label class="form-label-custom">Preço</label>
                                <input type="number" step="0.01" wire:model="produto.preco" class="form-control">
                                @error('produto.preco') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-1">
                                    <label class="form-label-custom">Estoque</label>
                                    <input type="number" wire:model="produto.estoque" class="form-control">
                                    @error('produto.estoque') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-2" wire:ignore>
                                <label class="form-label-custom">Categoria</label>
                                <select wire:model="categoriaSelecionada" class="form-control select2">
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

{{--                            <div class="col-md-2" wire:ignore>--}}
{{--                                <label class="form-label-custom">Subcategoria</label>--}}
{{--                                <select wire:model="produto.subcategoria_id" class="form-control form-select select2" multiple="multiple">--}}
{{--                                    <option value="">Selecione uma subcategoria</option>--}}
{{--                                    @foreach($subcategorias as $subcategoria)--}}
{{--                                        <option value="{{ $subcategoria->id }}">{{ $subcategoria->nome }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('produto.subcategoria_id') <span class="text-danger">{{ $message }}</span> @enderror--}}
{{--                            </div>--}}

                            <!-- Tabs -->
                            <div class="form-group mt-4">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Características</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="imagem-tab" data-bs-toggle="tab" data-bs-target="#imagem-tab-pane" type="button" role="tab" aria-controls="imagem-tab-pane" aria-selected="false">Imagens</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="fornecedor-tab" data-bs-toggle="tab" data-bs-target="#fornecedor-tab-pane" type="button" role="tab" aria-controls="fornecedor-tab-pane" aria-selected="false">Fornecedor</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tributacao-tab" data-bs-toggle="tab" data-bs-target="#tributacao-tab-pane" type="button" role="tab" aria-controls="tributacao-tab-pane" aria-selected="false">Tributação</button>
                                    </li>
                                    @if($tem_variacao)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="variacao-tab" data-bs-toggle="tab" data-bs-target="#variacao-tab-pane" type="button" role="tab" aria-controls="variacao-tab-pane" aria-selected="false">Variação</button>
                                        </li>
                                    @endif
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                        <div class="card mb-3 mt-2 p-2">
                                            <div class="row mt-3 mb-2 col-md-6">
                                                <div class="col-md-12" wire:ignore>
                                                    <label class="form-label-custom">Descrição Curta (Descrição Principal)</label>

                                                    {{-- Campo oculto para linkar com o Trix --}}
                                                    <input id="descricao" type="hidden" value="{{ $produto['descricao'] ?? '' }}">

                                                    {{-- Editor Trix --}}
                                                    <trix-editor input="descricao" class="form-control"></trix-editor>

                                                    {{-- Erro de validação --}}
                                                    @error('produto.descricao')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade mt-2" id="imagem-tab-pane" role="tabpanel" aria-labelledby="imagem-tab" tabindex="0">
                                        <div class="form-group" wire:ignore>
                                            <input type="file" name="file" id="uploadImagem" multiple />
                                        </div>

                                        @if ($imagemPreview)
                                            <div class="mt-2">
                                                <img src="{{ $imagemPreview }}" class="img-thumbnail" style="max-width: 200px;">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="fornecedor-tab-pane" role="tabpanel" aria-labelledby="fornecedor-tab" tabindex="0">..3.</div>
                                    <div class="tab-pane fade" id="tributacao-tab-pane" role="tabpanel" aria-labelledby="tributacao-tab" tabindex="0"></div>
                                    @if($tem_variacao)
                                        <div class="tab-pane fade" id="variacao-tab-pane" role="tabpanel" aria-labelledby="variacao-tab" tabindex="0">
                                            <div class="card mb-3 mt-2">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h5>Variações do Produto</h5>
                                                    <button type="button" wire:click="adicionarVariacao" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-plus"></i> Adicionar Variação
                                                    </button>
                                                </div>

                                                <div class="card-body">
                                                    @foreach($variacoes as $index => $variacao)
                                                        <div class="row mb-3 border-bottom pb-3 mt-2">
                                                            <div class="col-md-4">
                                                                <label class="form-label-custom">Nome</label>
                                                                <input type="text" wire:model="variacoes.{{ $index }}.nome" class="form-control">
                                                                @error('variacoes.'.$index.'.nome') <span class="text-danger">{{ $message }}</span> @enderror
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label-custom">SKU</label>
                                                                <input type="text" wire:model="variacoes.{{ $index }}.sku" class="form-control">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label-custom">Preço</label>
                                                                <input type="number" step="0.01" wire:model="variacoes.{{ $index }}.preco" class="form-control">
                                                                @error('variacoes.'.$index.'.preco') <span class="text-danger">{{ $message }}</span> @enderror
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label-custom">Estoque</label>
                                                                <input type="number" wire:model="variacoes.{{ $index }}.estoque" class="form-control">
                                                                @error('variacoes.'.$index.'.estoque') <span class="text-danger">{{ $message }}</span> @enderror
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-end">
                                                                <button type="button" wire:click="removerVariacao({{ $index }})" class="btn btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2 text-end">
                            <button type="submit" class="btn btn-primary">Salvar Produto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push("scripts")
    <script src="{{URL::asset("js/custom.js")}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const trixInput = document.querySelector("#descricao");
            const trixEditor = document.querySelector("trix-editor");

            trixEditor.addEventListener("trix-change", function () {
                const componentId = @json($this->getId());
                window.Livewire.find(componentId).set('produto.descricao', trixInput.value);
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const inputElement = document.querySelector('#uploadImagem');
            const pond = FilePond.create(inputElement);

            pond.setOptions({
                allowMultiple: true,
                allowImagePreview: true,
                server: {
                    process: {
                        url: '{{ route("upload.temp") }}',
                        method: 'POST',
                        withCredentials: false,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        onload: (res) => {
                            console.log("Resposta do servidor:", res); // Verifique isso!
                            const data = JSON.parse(res);
                            console.log("Imagem salva em:", data.path);

                            // Exemplo: mostrar preview manual
                            const img = document.createElement('img');
                            img.src = '/storage/' + data.path;
                            img.classList.add('img-fluid');
                            document.getElementById('preview-area').appendChild(img);
                        }
                    },
                    revert: null
                }
            });

            pond.on('addfile', (error, file) => {
                if (!error) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        window.Livewire.find('{{ $this->getId() }}').set('imagemPreview', reader.result);
                        window.Livewire.find('{{ $this->getId() }}').set('imagemArquivo', file.file);
                    };
                    reader.readAsDataURL(file.file);
                }
            });
        });
    </script>
@endpush
@push("styles")
    <link href="{{URL::asset("css/custom.css")}}" rel="stylesheet" />
@endpush

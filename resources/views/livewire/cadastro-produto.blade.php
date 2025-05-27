<div class="container-fluid px-4" xmlns:wire="http://www.w3.org/1999/xhtml"
     xmlns:x-transition="http://www.w3.org/1999/xhtml">

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
                            <div class="col-md-3">
                                <div class="form-group mb-2 col-md-4">
                                    <label class="form-label-custom">Código do Produto(Sku)</label>
                                    <input type="text" wire:model="produto.codigo_barras" class="form-control">
                                    @error('produto.codigo_barras') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mb-2 col-md-4">
                                    <label class="form-label-custom">Código de Barras</label>
                                    <input type="text" wire:model="produto.codigo_barras" class="form-control">
                                    @error('produto.codigo_barras') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mb-2 col-md-4">
                                    <label class="form-label-custom">Categoria</label>
                                    <select wire:model="categoriaSelecionada" class="form-control select2"  multiple="multiple">
                                        <option value="">Selecione uma categoria</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>



                            </div>

                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label class="form-label-custom">Nome do Produto</label>
                                    <input type="text" wire:model="produto.nome" class="form-control">
                                    @error('produto.nome') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mb-2">
                                    <label class="form-label-custom">Subcategoria</label>
                                    <select wire:model="produto.subcategoria_id" class="form-control select2" multiple="multiple">
                                        <option value="">Selecione uma subcategoria</option>
                                        @foreach($subcategorias as $subcategoria)
                                            <option value="{{ $subcategoria->id }}">{{ $subcategoria->nome }}</option>
                                        @endforeach
                                    </select>
                                    @error('produto.subcategoria_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mb-2">
                                    <label class="form-label-custom">Preço</label>
                                    <input type="number" step="0.01" wire:model="produto.preco" class="form-control">
                                    @error('produto.preco') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label-custom">Estoque</label>
                                    <input type="number" wire:model="produto.estoque" class="form-control">
                                    @error('produto.estoque') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group mb-2 col-md-4">
                                <label class="form-label-custom">Descrição</label>
                                <textarea wire:model="produto.descricao" class="form-control" rows="3"></textarea>
                                @error('produto.descricao') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Variações -->
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" wire:model="tem_variacao" id="tem_variacao" class="form-check-input">
                                <label for="tem_variacao" class="form-check-label">Este produto tem variações?</label>
                            </div>
                        </div>


                            <div
                                x-data="{ mostrar: @entangle('produto.tem_variacao').defer }"
                                x-show="mostrar"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="card mt-3 border-primary"
                            >
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Variações do Produto</h5>
                                    <button type="button" wire:click="adicionarVariacao" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Adicionar Variação
                                    </button>
                                </div>
                                <div class="card-body">
                                    @foreach($variacoes as $index => $variacao)
                                        <div class="row mb-3 border-bottom pb-3">
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
                        <div class="form-group">
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
@endpush
@push("styles")
    <link href="{{URL::asset("css/custom.css")}}" rel="stylesheet" />
@endpush

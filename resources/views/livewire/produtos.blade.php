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
                                Produtos
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <div wire:loading.class="opacity-50">
                <div class="card mb-2">
                    <div class="form-group mb-2 mt-2 px-2" style="max-width: 400px; position: relative;">
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            class="form-control rounded-3 ps-3 pe-5"
                            placeholder="Pesquisar por código, descrição ou GTIN">
                            <i class="fa fa-search text-success position-absolute"
                           style="right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none;"></i>
                    </div>


                    <div class="p-2 mb-2 rounded-lg shadow-sm">
                        @if ($produtos->count())
                            <table class="table table table-striped mb-0 ml-4 table-hover dark-header rounded border overflow-hidden">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;"></th>
                                        <th>Descrição</th>
                                        <th>Código</th>
                                        <th>Preço</th>
                                        <th>Estoque</th>
                                        <th style="width: 100px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($produtos as $produto)
                                        <tr wire:key="produto-{{ $produto->id }}"
                                            class="{{ $expandedProdutoId === $produto->id ? 'table-primary' : 'table-light' }}">
                                            <td>
                                                @if($produto->variacoes->isNotEmpty())
                                                    <a href="#" wire:click.prevent="toggleVariacoes({{ $produto->id }})"
                                                       title="{{ ($expanded[$produto->id] ?? false) ? 'Ocultar Variações' : 'Mostrar Variações' }}">
                                                        @if($expanded[$produto->id] ?? false)
                                                            <i class="fas fa-minus-circle text-danger"></i> <!-- Ícone de menos (vermelho) -->
                                                        @else
                                                            <i class="fas fa-plus-circle text-success"></i> <!-- Ícone de mais (verde) -->
                                                        @endif
                                                    </a>
                                                @endif
                                            </td>

                                            <td>
                                                @if($editingId === 'pai-'.$produto->id)
                                                    <input wire:model="editData.nome" class="form-control">
                                                @else
                                                    {{ $produto->nome }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($editingId === 'pai-'.$produto->id)
                                                    <input wire:model="editData.sku" class="form-control">
                                                @else
                                                    {{ $produto->sku }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($editingId === 'pai-'.$produto->id)
                                                    <input wire:model="editData.preco" type="number" class="form-control">
                                                @else
                                                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($editingId === 'pai-'.$produto->id)
                                                    <input wire:model="editData.estoque" type="number" class="form-control">
                                                @else
                                                    {{ $produto->estoque }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($editingId === 'pai-'.$produto->id)
                                                    <button wire:click="saveEdit('pai', {{ $produto->id }})"
                                                            class="btn btn-sm btn-success">
                                                        <i class="fas fa-save"></i> Salvar
                                                    </button>
                                                @else
                                                    <button wire:click="startEdit('pai', {{ $produto->id }})"
                                                            class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- Variações --}}
                                        @if($expanded[$produto->id] ?? false)
                                            <tr class="bg-light" wire:key="produto-expandido-{{ $produto->id }}">
                                                <td colspan="100" class="p-2 border-0">
                                                    <!-- Subtabela de variações -->
                                                    <table class="table table-striped table-hover table-sm mb-0 ml-4 dark-header rounded border overflow-hidden">
                                                        <thead class="bg-dark">
                                                            <tr>
                                                                <th></th>
                                                                <th>Descrição</th>
                                                                <th>Código </th>
                                                                <th>Preço</th>
                                                                <th>Estoque</th>
                                                                <th>Quantidade</th>
                                                                <th style="width: 100px;">Ações</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($produto->variacoes as $index => $variacao)
                                                            <tr wire:key="variacao-{{ $variacao->id }}">
                                                                <td style="width: 0px;"></td>
                                                                <td class="pl-4">
                                                                    @if($editingId === 'filho-'.$variacao->id)
                                                                        <input wire:model="editData.nome" class="form-control">
                                                                    @else
                                                                        {{ $variacao->nome }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($editingId === 'filho-'.$variacao->id)
                                                                        <input wire:model="editData.sku" class="form-control">
                                                                    @else
                                                                        {{ $variacao->sku }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($editingId === 'filho-'.$variacao->id)
                                                                        <input wire:model="editData.preco" type="number" class="form-control">
                                                                    @else
                                                                        R$ {{ number_format($variacao->preco, 2, ',', '.') }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($editingId === 'filho-'.$variacao->id)
                                                                        <input wire:model="editData.estoque" type="number" class="form-control">
                                                                    @else
                                                                        {{ $variacao->estoque }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($editingId === 'filho-'.$variacao->id)
                                                                        <input wire:model="editData.quantidade" type="number" class="form-control">
                                                                    @else
                                                                        {{ $variacao->quantidade }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($editingId === 'filho-'.$variacao->id)
                                                                        <button wire:click="saveEdit('filho', {{ $variacao->id }})" class="btn btn-sm btn-success">
                                                                            <i class="fas fa-save"></i> Salvar
                                                                        </button>
                                                                    @else
                                                                        <button wire:click="startEdit('filho', {{ $variacao->id }})" class="btn btn-sm btn-primary">
                                                                            <i class="fas fa-edit"></i> Editar
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="d-flex align-items-center justify-content-center flex-column py-5 text-muted bg-light rounded">
                                <i class="fa fa-search fa-3x mb-3"></i>
                                <p class="mb-0">Nenhum produto encontrado com esse termo.</p>
                            </div>
                        @endif
                    </div>
                    @if ($produtos->count())
                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap p-2">
                            <div class="text-muted small mb-2 mb-md-0">
                                Mostrando {{ $produtos->firstItem() }} a {{ $produtos->lastItem() }} de {{ $produtos->total() }} registros
                            </div>
                            <div>
                                {!! $produtos->links('pagination::bootstrap-4') !!}
                            </div>
                        </div>
                    @endif
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




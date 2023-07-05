using App.Models;
using App.Services.Interfaces;
using App.Services.Results;

namespace App.Services;

public class OrdemProducaoService : IOrdemProducaoService
{
    private readonly DataBaseContext _dataBaseContext;

    private readonly Dictionary<Categoria, int> _duracoesEmMinutos =
        new()
        {
            // 40 dias
            { Categoria.Artesanal, 57600 },
            // 36 horas
            { Categoria.SemAlcool, 2160 },
            // 40 dias
            { Categoria.Tradicional, 57600 },
        };

    public OrdemProducaoService(DataBaseContext context)
    {
        _dataBaseContext = context;
    }

    public async Task<ServiceResult<OrdemProducao>> CreateAsync(OrdemProducao ordemProducao)
    {
        ordemProducao.EtapaNoProcesso = Processo.Maltagem;
        ordemProducao.Status = OrdemProducaoStatus.Aguardando;

        await _dataBaseContext.OrdensProducao.AddAsync(ordemProducao);

        await _dataBaseContext.SaveChangesAsync();

        if (ordemProducao.Id == 0)
            return ServiceResult<OrdemProducao>.Failure("Erro ao cadastrar ordem de produção");

        return ServiceResult<OrdemProducao>.Success(ordemProducao);
    }

    public Task<ServiceResult<OrdemProducaoOutput>> GetProcessStepAsync(
        int pagina,
        int tamanhoPagina,
        int UserId
    )
    {
        if (tamanhoPagina == 0)
            return Task.FromResult(
                ServiceResult<OrdemProducaoOutput>.Failure("Por favor, informe o tamanho da página")
            );

        var totalPages =
            _dataBaseContext.OrdensProducao.Count() == 0
                ? 0
                : (int)
                    Math.Ceiling((double)_dataBaseContext.OrdensProducao.Count() / tamanhoPagina);

        var OrdensProducao = _dataBaseContext.OrdensProducao
            .Where(o => o.Status != OrdemProducaoStatus.Finalizado && o.UsuarioId == UserId)
            .Skip((pagina - 1) * tamanhoPagina)
            .Take(tamanhoPagina);

        var ordensProducaoOutput = new OrdemProducaoOutput()
        {
            OrdensProducao = OrdensProducao,
            Total = _dataBaseContext.OrdensProducao.Count(),
            TotalPages = totalPages
        };

        return Task.FromResult(ServiceResult<OrdemProducaoOutput>.Success(ordensProducaoOutput));
    }
}

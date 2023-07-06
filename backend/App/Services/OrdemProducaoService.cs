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
            { Categoria.Tradicional, 57600 },
            // 40 dias
            { Categoria.Artesanal, 57600 },
            // 36 horas
            { Categoria.SemAlcool, 2160 },
        };

    public OrdemProducaoService(DataBaseContext context)
    {
        _dataBaseContext = context;
    }

    public async Task<ServiceResult<OrdemProducao>> CreateAsync(OrdemProducao ordemProducao)
    {
        ordemProducao.EtapaNoProcesso = 0;
        ordemProducao.Status = OrdemProducaoStatus.Aguardando;

        await _dataBaseContext.OrdensProducao.AddAsync(ordemProducao);

        await _dataBaseContext.SaveChangesAsync();

        if (ordemProducao.Id == 0)
            return ServiceResult<OrdemProducao>.Failure("Erro ao cadastrar ordem de produção");

        return ServiceResult<OrdemProducao>.Success(ordemProducao);
    }

    public async Task<ServiceResult<OrdemProducao>> DeleteAsync(int id, int userId)
    {
        var ordemProducao = await _dataBaseContext.OrdensProducao.FindAsync(id);

        if (ordemProducao == null)
            return ServiceResult<OrdemProducao>.Failure("Ordem de produção não encontrada");

        if (ordemProducao.UsuarioId != userId)
            return ServiceResult<OrdemProducao>.Failure(
                "Você não tem permissão para excluir esta ordem de produção"
            );

        _dataBaseContext.OrdensProducao.Remove(ordemProducao);

        await _dataBaseContext.SaveChangesAsync();

        return ServiceResult<OrdemProducao>.Success(ordemProducao);
    }

    public async Task<ServiceResult<OrdemProducao>> DeleteProductionOrderAsync(int id, int userId)
    {
        var ordemProducao = await _dataBaseContext.OrdensProducao.FindAsync(id);

        if (ordemProducao == null)
            return ServiceResult<OrdemProducao>.Failure("Ordem de produção não encontrada");

        if (ordemProducao.UsuarioId != userId)
            return ServiceResult<OrdemProducao>.Failure(
                "Você não tem permissão para excluir esta ordem de produção"
            );

        if (
            ordemProducao.EtapaNoProcesso != Processo.Finalizacao
            && ordemProducao.Status != OrdemProducaoStatus.Cancelado
            && ordemProducao.Status != OrdemProducaoStatus.Finalizado
            && ordemProducao.Status != OrdemProducaoStatus.Aguardando
        )
            return ServiceResult<OrdemProducao>.Failure(
                "Você não pode excluir uma ordem de produção que já foi iniciada, para excluir finalize a ordem de produção ou cancele a mesma"
            );

        _dataBaseContext.OrdensProducao.Remove(ordemProducao);

        await _dataBaseContext.SaveChangesAsync();

        return ServiceResult<OrdemProducao>.Success(ordemProducao);
    }

    public async Task<ServiceResult<OrdemProducao>> FinalizeProductionOrderAsync(int id, int userId)
    {
        var ordemProducao = await _dataBaseContext.OrdensProducao.FindAsync(id);

        if (ordemProducao == null)
            return ServiceResult<OrdemProducao>.Failure("Ordem de produção não encontrada");

        if (ordemProducao.UsuarioId != userId)
            return ServiceResult<OrdemProducao>.Failure(
                "Você não tem permissão para finalizar esta ordem de produção"
            );

        ordemProducao.Status = OrdemProducaoStatus.Cancelado;
        ordemProducao.DataFim = DateTime.UtcNow;

        _dataBaseContext.OrdensProducao.Update(ordemProducao);

        await _dataBaseContext.SaveChangesAsync();

        return ServiceResult<OrdemProducao>.Success(ordemProducao);
    }

    public Task<ServiceResult<OrdemProducaoOutput>> GetAllActivatedProductionOrderAsync(
        int pagina,
        int tamanhoPagina,
        int userId
    )
    {
        if (tamanhoPagina == 0)
            return Task.FromResult(
                ServiceResult<OrdemProducaoOutput>.Failure("Por favor, informe o tamanho da página")
            );

        var totalPages =
            _dataBaseContext.OrdensProducao.Count() == 0
                ? 1
                : (int)
                    Math.Ceiling((double)_dataBaseContext.OrdensProducao.Count() / tamanhoPagina);

        // as que estão finalizadas ficam no final
        var ordensProducao = _dataBaseContext.OrdensProducao
            .Where(o => o.UsuarioId == userId)
            .OrderBy(o => o.Status)
            .Skip((pagina - 1) * tamanhoPagina)
            .Take(tamanhoPagina)
            .ToList();

        var ordensProducaoOutput = new OrdemProducaoOutput()
        {
            OrdensProducao = ordensProducao,
            Total = _dataBaseContext.OrdensProducao.Count(),
            TotalPages = totalPages
        };

        return Task.FromResult(ServiceResult<OrdemProducaoOutput>.Success(ordensProducaoOutput));
    }

    public Task<ServiceResult<OrdemProducaoOutput>> GetAllFinishedProductionOrderAsync(
        int pagina,
        int tamanhoPagina,
        int userId
    )
    {
        var ordensProducao = _dataBaseContext.OrdensProducao
            .Where(
                o =>
                    o.UsuarioId == userId
                    && o.Status == OrdemProducaoStatus.Finalizado
                    && o.EtapaNoProcesso == Processo.Finalizacao
            )
            .OrderBy(o => o.Status)
            .Skip((pagina - 1) * tamanhoPagina)
            .Take(tamanhoPagina);

        var totalPages =
            ordensProducao.Count() == 0
                ? 1
                : (int)Math.Ceiling((double)ordensProducao.Count() / tamanhoPagina);

        var ordensProducaoOutput = new OrdemProducaoOutput()
        {
            OrdensProducao = ordensProducao,
            Total = ordensProducao.Count(),
            TotalPages = totalPages
        };

        return Task.FromResult(ServiceResult<OrdemProducaoOutput>.Success(ordensProducaoOutput));
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
            _dataBaseContext.OrdensProducao
                .Where(
                    o =>
                        o.EtapaNoProcesso != Processo.Finalizacao
                        && o.Status != OrdemProducaoStatus.Finalizado
                        && o.Status != OrdemProducaoStatus.Cancelado
                )
                .Count() == 0
                ? 1
                : (int)
                    Math.Ceiling(
                        (double)
                            _dataBaseContext.OrdensProducao
                                .Where(
                                    o =>
                                        o.EtapaNoProcesso != Processo.Finalizacao
                                        && o.Status != OrdemProducaoStatus.Finalizado
                                )
                                .Count() / tamanhoPagina
                    );

        var OrdensProducao = _dataBaseContext.OrdensProducao
            .Where(
                o =>
                    o.EtapaNoProcesso < Processo.Finalizacao
                    && o.Status != OrdemProducaoStatus.Finalizado
                    && o.Status != OrdemProducaoStatus.Cancelado
                    && o.UsuarioId == UserId
            )
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

    public async Task<ServiceResult<OrdemProducao>> UpdateProcessStepAsync(
        int id,
        int userId,
        Processo processStep
    )
    {
        var ordemProducao = await _dataBaseContext.OrdensProducao.FindAsync(id);

        if (ordemProducao == null)
            return ServiceResult<OrdemProducao>.Failure("Ordem de produção não encontrada");

        if (ordemProducao.UsuarioId != userId)
            return ServiceResult<OrdemProducao>.Failure(
                "Você não tem permissão para alterar esta ordem de produção"
            );

        if (
            ordemProducao.Status == OrdemProducaoStatus.Cancelado
            || ordemProducao.Status == OrdemProducaoStatus.Finalizado
        )
            return ServiceResult<OrdemProducao>.Failure("Esta ordem de produção já foi finalizada");

        if (ordemProducao.EtapaNoProcesso == processStep)
            return ServiceResult<OrdemProducao>.Failure(
                "Esta ordem de produção já está nesta etapa"
            );

        if (ordemProducao.EtapaNoProcesso > processStep)
            return ServiceResult<OrdemProducao>.Failure(
                "Esta ordem de produção já passou desta etapa"
            );

        if (ordemProducao.EtapaNoProcesso == 0)
        {
            ordemProducao.DataInicio = DateTime.UtcNow;
            ordemProducao.DataFim = DateTime.UtcNow.AddMinutes(
                _duracoesEmMinutos[ordemProducao.Categoria]
            );
            ordemProducao.Status = OrdemProducaoStatus.Execucao;
        }
        else if (processStep == Processo.Finalizacao)
        {
            ordemProducao.DataFim = DateTime.UtcNow;
            ordemProducao.Status = OrdemProducaoStatus.Finalizado;
        }
        ordemProducao.EtapaNoProcesso = processStep;

        _dataBaseContext.OrdensProducao.Update(ordemProducao);

        await _dataBaseContext.SaveChangesAsync();

        return ServiceResult<OrdemProducao>.Success(ordemProducao);
    }

    public async Task<ServiceResult<OrdemProducao>> UpdateQuantityAsync(
        int id,
        int userId,
        int quantity
    )
    {
        var ordemProducao = await _dataBaseContext.OrdensProducao.FindAsync(id);

        if (ordemProducao == null)
            return ServiceResult<OrdemProducao>.Failure("Ordem de produção não encontrada");

        if (ordemProducao.UsuarioId != userId)
            return ServiceResult<OrdemProducao>.Failure(
                "Você não tem permissão para alterar esta ordem de produção"
            );

        if (
            ordemProducao.Status == OrdemProducaoStatus.Cancelado
            || ordemProducao.Status == OrdemProducaoStatus.Finalizado
            || ordemProducao.EtapaNoProcesso == Processo.Finalizacao
        )
            return ServiceResult<OrdemProducao>.Failure(
                "Esta ordem de produção já foi finalizada e de acordo com a etapa do processo não pode ser alterada"
            );

        ordemProducao.Quantidade = quantity;

        _dataBaseContext.OrdensProducao.Update(ordemProducao);

        await _dataBaseContext.SaveChangesAsync();

        return ServiceResult<OrdemProducao>.Success(ordemProducao);
    }
}

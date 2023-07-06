using App.Models;
using App.Services.Results;

namespace App.Services.Interfaces;

public class OrdemProducaoOutput
{
    public IEnumerable<OrdemProducao> OrdensProducao { get; set; } = new List<OrdemProducao>();
    public int Total { get; set; }

    public int TotalPages { get; set; }
}

public interface IOrdemProducaoService
{
    Task<ServiceResult<OrdemProducao>> CreateAsync(OrdemProducao ordemProducao);

    Task<ServiceResult<OrdemProducaoOutput>> GetProcessStepAsync(
        int pagina,
        int tamanhoPagina,
        int UserId
    );

    Task<ServiceResult<OrdemProducao>> UpdateProcessStepAsync(
        int id,
        int userId,
        Processo processStep
    );

    Task<ServiceResult<OrdemProducao>> DeleteAsync(int id, int userId);
}

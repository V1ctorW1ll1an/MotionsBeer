using App.Models;
using App.Services.Interfaces;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;

namespace App.Controllers;

[ApiController]
[Route("api/[controller]")]
[Authorize(Roles = "Admin,Usuario")]
public class OrdemProducaoController : ControllerBase
{
    private readonly IOrdemProducaoService _ordemProducaoService;

    public OrdemProducaoController(IOrdemProducaoService ordemProducaoService)
    {
        _ordemProducaoService = ordemProducaoService;
    }

    [HttpPost]
    public async Task<IActionResult> Create([FromBody] OrdemProducao ordemProducao)
    {
        try
        {
            var id = User.Claims.FirstOrDefault(c => c.Type == "id");

            if (id == null)
                return BadRequest(new { mensagem = "Usuário não autenticado" });

            var userId = int.Parse(id.Value);
            ordemProducao.UsuarioId = userId;

            var resultado = await _ordemProducaoService.CreateAsync(ordemProducao);

            if (!resultado.IsSuccess)
                return BadRequest(new { mensagem = resultado.ErrorMessage });

            return Ok(
                new
                {
                    mensagem = "Ordem de produção cadastrada com sucesso",
                    ordemProducao = resultado.Value
                }
            );
        }
        catch (System.Exception)
        {
            return BadRequest(new { mensagem = "Erro ao cadastrar funcionário" });
        }
    }

    [HttpGet("ProcessStep")]
    public async Task<IActionResult> GetProcessStep(
        [FromQuery] int pagina,
        [FromQuery] int tamanhoPagina
    )
    {
        try
        {
            var id = User.Claims.FirstOrDefault(c => c.Type == "id");

            if (id == null)
                return BadRequest(new { mensagem = "Usuário não autenticado" });

            var userId = int.Parse(id.Value);

            var resultado = await _ordemProducaoService.GetProcessStepAsync(
                pagina,
                tamanhoPagina,
                userId
            );

            if (!resultado.IsSuccess)
                return BadRequest(new { mensagem = resultado.ErrorMessage });

            var ordensProducao = resultado.Value.OrdensProducao.Select(
                o => new { o.Id, o.EtapaNoProcesso }
            );

            return Ok(
                new
                {
                    mensagem = "Lista com todas as ordens de produção",
                    ordensProducao = ordensProducao,
                    total = resultado.Value.Total,
                    totalPages = resultado.Value.TotalPages
                }
            );
        }
        catch (System.Exception)
        {
            return BadRequest(new { mensagem = "Erro ao retornar ordens de produção" });
        }
    }
}

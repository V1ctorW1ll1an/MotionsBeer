using App.Dto;
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

    [HttpPut("ProcessStep/{id}")]
    public async Task<IActionResult> UpdateProcessStep(
        [FromRoute] int id,
        [FromBody] UpdateProcessDto processForm
    )
    {
        try
        {
            var userId = User.Claims.FirstOrDefault(c => c.Type == "id");

            if (userId == null)
                return BadRequest(new { mensagem = "Usuário não autenticado" });

            var userIdInt = int.Parse(userId.Value);

            var resultado = await _ordemProducaoService.UpdateProcessStepAsync(
                id,
                userIdInt,
                processForm.NovaEtapa
            );

            if (!resultado.IsSuccess)
                return BadRequest(new { mensagem = resultado.ErrorMessage });

            return Ok(
                new
                {
                    mensagem = "A etapa do processo foi atualizada com sucesso",
                    ordemProducao = resultado.Value
                }
            );
        }
        catch (System.Exception)
        {
            return BadRequest(new { mensagem = "Erro ao atualizar etapa do processo" });
        }
    }

    [HttpDelete("{id}")]
    public async Task<IActionResult> Delete([FromRoute] int id)
    {
        try
        {
            var userId = User.Claims.FirstOrDefault(c => c.Type == "id");

            if (userId == null)
                return BadRequest(new { mensagem = "Usuário não autenticado" });

            var userIdInt = int.Parse(userId.Value);

            var resultado = await _ordemProducaoService.DeleteAsync(id, userIdInt);

            if (!resultado.IsSuccess)
                return BadRequest(new { mensagem = resultado.ErrorMessage });

            return Ok(
                new
                {
                    mensagem = "Ordem de produção deletada com sucesso",
                    ordemProducaoId = resultado.Value.Id
                }
            );
        }
        catch (System.Exception)
        {
            return BadRequest(new { mensagem = "Erro ao deletar ordem de produção" });
        }
    }

    [HttpPut("finalizeProductionOrder/{id}")]
    public async Task<IActionResult> FinalizeProductionOrder([FromRoute] int id)
    {
        try
        {
            var userId = User.Claims.FirstOrDefault(c => c.Type == "id");

            if (userId == null)
                return BadRequest(new { mensagem = "Usuário não autenticado" });

            var userIdInt = int.Parse(userId.Value);

            var resultado = await _ordemProducaoService.FinalizeProductionOrderAsync(id, userIdInt);

            if (!resultado.IsSuccess)
                return BadRequest(new { mensagem = resultado.ErrorMessage });

            return Ok(
                new
                {
                    mensagem = "Ordem de produção interrompida com sucesso",
                    ordemProducaoId = resultado.Value.Id
                }
            );
        }
        catch (System.Exception)
        {
            return BadRequest(new { mensagem = "Erro ao interromper ordem de produção" });
        }
    }

    [HttpGet("GetAllActivatedProductionOrder")]
    public async Task<IActionResult> GetAllActivatedProductionOrder(
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

            var resultado = await _ordemProducaoService.GetAllActivatedProductionOrderAsync(
                pagina,
                tamanhoPagina,
                userId
            );

            if (!resultado.IsSuccess)
                return BadRequest(new { mensagem = resultado.ErrorMessage });

            return Ok(
                new
                {
                    mensagem = "Lista com todas as ordens de produção",
                    ordensProducao = resultado.Value.OrdensProducao,
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

    [HttpPut("UpdateQuantity/{id}")]
    public async Task<IActionResult> UpdateQuantity(
        [FromRoute] int id,
        [FromBody] UpdateQuantityDto quantidadeForm
    )
    {
        try
        {
            var userId = User.Claims.FirstOrDefault(c => c.Type == "id");

            if (userId == null)
                return BadRequest(new { mensagem = "Usuário não autenticado" });

            var userIdInt = int.Parse(userId.Value);

            var resultado = await _ordemProducaoService.UpdateQuantityAsync(
                id,
                userIdInt,
                quantidadeForm.quantidade
            );

            if (!resultado.IsSuccess)
                return BadRequest(new { mensagem = resultado.ErrorMessage });

            return Ok(
                new
                {
                    mensagem = "A quantidade da ordem de produção foi atualizada com sucesso",
                    ordemProducao = resultado.Value
                }
            );
        }
        catch (System.Exception)
        {
            return BadRequest(
                new { mensagem = "Erro ao atualizar quantidade da ordem de produção" }
            );
        }
    }

    [HttpDelete("DeleteProductionOrder/{id}")]
    public async Task<IActionResult> DeleteProductionOrder([FromRoute] int id)
    {
        try
        {
            var userId = User.Claims.FirstOrDefault(c => c.Type == "id");

            if (userId == null)
                return BadRequest(new { mensagem = "Usuário não autenticado" });

            var userIdInt = int.Parse(userId.Value);

            var resultado = await _ordemProducaoService.DeleteProductionOrderAsync(id, userIdInt);

            if (!resultado.IsSuccess)
                return BadRequest(new { mensagem = resultado.ErrorMessage });

            return Ok(
                new
                {
                    mensagem = "Ordem de produção apagada com sucesso",
                    ordemProducaoId = resultado.Value.Id
                }
            );
        }
        catch (System.Exception)
        {
            return BadRequest(new { mensagem = "Erro ao apagar ordem de produção" });
        }
    }

    [HttpGet("GetAllFinishedProductionOrder")]
    public async Task<IActionResult> GetAllFinishedProductionOrder(
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

            var resultado = await _ordemProducaoService.GetAllFinishedProductionOrderAsync(
                pagina,
                tamanhoPagina,
                userId
            );

            if (!resultado.IsSuccess)
                return BadRequest(new { mensagem = resultado.ErrorMessage });

            return Ok(
                new
                {
                    mensagem = "Lista com todas as ordens de produção",
                    ordensProducao = resultado.Value.OrdensProducao,
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

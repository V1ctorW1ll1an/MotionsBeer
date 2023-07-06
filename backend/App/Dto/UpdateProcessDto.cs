using System.ComponentModel.DataAnnotations;
using App.Models;

namespace App.Dto;

public class UpdateProcessDto
{
    [Required(ErrorMessage = "etapa do processo é obrigatório")]
    public Processo NovaEtapa { get; set; }
}

using System.ComponentModel.DataAnnotations;

namespace App.Models;

public class OrdemProducao
{
    public int Id { get; set; }
    public DateOnly DataInicio { get; set; } = DateOnly.FromDateTime(DateTime.Now);
    public DateOnly DataFim { get; set; }

    [Required(ErrorMessage = "Campo obrigatório")]
    public int Quantidade { get; set; }
    public OrdemProducaoStatus Status { get; set; }
    public Categoria Categoria { get; set; }
    public int UsuarioId { get; set; }
    public Usuario Usuario { get; set; } = default!;
    public Processo EtapaNoProcesso { get; set; }
}

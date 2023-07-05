using System.ComponentModel.DataAnnotations;
using System.Text.Json.Serialization;

namespace App.Models;

public class OrdemProducao
{
    public int Id { get; set; }

    [DataType(DataType.DateTime)]
    public DateTime DataCriacao { get; set; } = DateTime.Now;

    [DataType(DataType.DateTime)]
    public DateTime? DataInicio { get; set; } = null;

    [DataType(DataType.DateTime)]
    public DateTime? DataFim { get; set; } = null;

    [Range(1, int.MaxValue, ErrorMessage = "A quantidade deve ser maior que zero")]
    public int Quantidade { get; set; }
    public OrdemProducaoStatus Status { get; set; }
    public Categoria Categoria { get; set; }
    public int UsuarioId { get; set; }

    [JsonIgnore]
    public Usuario? Usuario { get; set; }
    public Processo EtapaNoProcesso { get; set; }
}

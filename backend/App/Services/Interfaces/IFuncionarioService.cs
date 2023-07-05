using App.Dto;
using App.Models;
using App.Services.Results;

namespace App.Services.Interfaces;

public class ObterUsuariosOutput
{
    public IEnumerable<Usuario> Usuarios { get; set; } = new List<Usuario>();
    public int TotalPages { get; set; }
}

public interface IUsuarioService
{
    public Task<ServiceResult<Usuario>> AutenticarUsuarioAsync(LoginUsuario usuarioInput);
    public Task<ServiceResult<Usuario>> CadastrarUsuarioAsync(Usuario usuarioInput);
    public Task<ServiceResult<Usuario>> AtualizarUsuarioAsync(Usuario usuarioInput, int id);
    public Task<ServiceResult<Usuario>> DesativarUsuarioAsync(int id);

    public Task<ServiceResult<Usuario>> ObterUsuarioAsync(int id);

    public Task<ServiceResult<ObterUsuariosOutput>> ObterUsuariosAsync(
        int pagina,
        int tamanhoPagina
    );

    public Task<ServiceResult<IEnumerable<Usuario>>> ObterUsuariosDesativadosAsync();
}

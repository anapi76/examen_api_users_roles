<?php

namespace App\Controller;

use App\Entity\Conexiones;
use App\Entity\Ips;
use App\Entity\Usuario;
use App\Repository\ConexionesRepository;
use App\Repository\IpsRepository;
use App\Repository\RolesRepository;
use App\Repository\UsuarioRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends AbstractController
{
    private UsuarioRepository $usuarioRepository;
    private RolesRepository $rolesRepository;
    private IpsRepository $ipsRepository;
    private ConexionesRepository $conexionesRepository;

    public function __construct(UsuarioRepository $usuarioRepository, RolesRepository $rolesRepository, IpsRepository $ipsRepository, ConexionesRepository $conexionesRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->rolesRepository = $rolesRepository;
        $this->ipsRepository = $ipsRepository;
        $this->conexionesRepository = $conexionesRepository;
    }

    #[Route('/user', name: 'app_usuario', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent());
            if (is_null($data)) {
                return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Error al decodificar el archivo json', 'status' => '404'], Response::HTTP_BAD_REQUEST);
            }
            if ((!isset($data->username) || empty($data->username)) || (!isset($data->nombre) || empty($data->nombre)) || (!isset($data->papellido) || empty($data->papellido)) || (!isset($data->sexo))) {
                return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Faltan parámetros', 'status' => '404'], Response::HTTP_BAD_REQUEST);
            }
            $usuario = $this->usuarioRepository->findOneBy(['username' => $data->username]);
            if (!is_null($usuario)) {
                return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'El username ya existe', 'status' => '404'], Response::HTTP_BAD_REQUEST);
            }
            $newUsuario = new Usuario();
            $newUsuario->setUsername($data->username);
            $newUsuario->setNombre($data->nombre);
            $newUsuario->setPrimerapellido($data->papellido);
            if (!is_bool($data->sexo)) {
                return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Error en el tipo de dato sexo, introduce un booleano', 'status' => '404'], Response::HTTP_BAD_REQUEST);
            }
            $newUsuario->setSexo($data->sexo);
            if (isset($data->sapellido) && !empty($data->sapellido)) {
                $newUsuario->setSegundoapellido($data->sapellido);
            }
            if (isset($data->altura) && !empty($data->altura)) {
                if (!is_int($data->altura)) {
                    return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Error en el tipo de dato altura, introduce un número entero', 'status' => '404'], Response::HTTP_BAD_REQUEST);
                }
                $newUsuario->setAltura($data->altura);
            }
            if (isset($data->peso) && !empty($data->peso)) {
                if (!is_float($data->peso)) {
                    return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Error en el tipo de dato peso, introduce un número decimal', 'status' => '404'], Response::HTTP_BAD_REQUEST);
                }
                $newUsuario->setPeso($data->peso);
            }
            if (isset($data->fechaNacimiento) && !empty($data->fechaNacimiento)) {
                $fechaNacimiento = new DateTime($data->fechaNacimiento);
                $newUsuario->setFechaNacimiento($fechaNacimiento);
            }
            if (isset($data->rol) && !empty($data->rol)) {
                $rol = $this->rolesRepository->findOneBy(['nombre' => $data->rol]);
                if (!is_null($rol)) {
                    $newUsuario->setRol($rol);
                }
            }
            if (isset($data->ip) && !empty($data->ip)) {
                $ip = $this->ipsRepository->findOneBy(['direccion' => $data->ip]);
                if (is_null($ip)) {
                    return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'La dirección ip no existe', 'status' => '404'], Response::HTTP_BAD_REQUEST);
                }
                $conexion = new Conexiones();
                $conexion->setIdIp($ip);
                $conexion->setInicio(new DateTime());
                $this->conexionesRepository->persist($conexion);
                $newUsuario->addConexion($conexion);
            }
            if (isset($data->conectado) && !empty($data->conectado)) {
                $conectado = new DateTime($data->conectado);
                $newUsuario->setAlta($conectado);
            }
            $this->usuarioRepository->save($newUsuario, true);
            if ($this->usuarioRepository->testInsert($data->username)) {
                return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Insertado correctamente', 'status' => '201'], Response::HTTP_CREATED);
            } else {
                return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Error en la inserción', 'status' => '500'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (Exception $e) {
            $msg = 'Error del servidor: ' . $e->getMessage();
            return new JsonResponse(['status' => $msg], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/user/{id}', name: 'app_usuario_get', methods: ['GET', 'PUT', 'PATCH', 'DELETE'])]
    public function show(Request $request, ?Usuario $usuario = null): JsonResponse
    {
        $method = $request->getMethod();
        if (is_null($usuario)) {
            return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'El usuario no existe en la bd', 'status' => '404'], Response::HTTP_NOT_FOUND);
        }
        if ($method === 'GET') {
            $json = $this->usuarioRepository->usuarioJSON($usuario);
            return new JsonResponse($json, Response::HTTP_OK);
        } elseif ($method === 'PUT' || $method === 'PATCH') {
            try {
                $data = json_decode($request->getContent());
                if (is_null($data)) {
                    return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Error al decodificar el archivo json', 'status' => '404'], Response::HTTP_BAD_REQUEST);
                }
                if (isset($data->username) && empty($data->username)) {
                    return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'El username no se puede modificar', 'status' => '404'], Response::HTTP_BAD_REQUEST);
                }
                if (isset($data->nombre) && empty($data->nombre)) {
                    $usuario->setNombre($data->nombre);
                }
                if (isset($data->papellido) && empty($data->papellido)) {
                    $usuario->setPrimerapellido($data->papellido);
                }
                if (isset($data->sexo)) {
                    if (!is_bool($data->sexo)) {
                        return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Error en el tipo de dato sexo, introduce un booleano', 'status' => '404'], Response::HTTP_BAD_REQUEST);
                    }
                    $usuario->setSexo($data->sexo);
                }
                if (isset($data->sapellido) && !empty($data->sapellido)) {
                    $usuario->setSegundoapellido($data->sapellido);
                }
                if (isset($data->altura) && !empty($data->altura)) {
                    if (!is_int($data->altura)) {
                        return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Error en el tipo de dato altura, introduce un número entero', 'status' => '404'], Response::HTTP_BAD_REQUEST);
                    }
                    $usuario->setAltura($data->altura);
                }
                if (isset($data->peso) && !empty($data->peso)) {
                    if (!is_float($data->peso)) {
                        return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Error en el tipo de dato peso, introduce un número decimal', 'status' => '404'], Response::HTTP_BAD_REQUEST);
                    }
                    $usuario->setPeso($data->peso);
                }
                if (isset($data->fechaNacimiento) && !empty($data->fechaNacimiento)) {
                    $fechaNacimiento = new DateTime($data->fechaNacimiento);
                    $usuario->setFechaNacimiento($fechaNacimiento);
                }
                if (isset($data->rol) && !empty($data->rol)) {
                    $rol = $this->rolesRepository->findOneBy(['nombre' => $data->rol]);
                    if (!is_null($rol)) {
                        $usuario->setRol($rol);
                    }
                }
                if (isset($data->ip) && !empty($data->ip)) {
                    $ip = $this->ipsRepository->findOneBy(['direccion' => $data->ip]);
                    if (is_null($ip)) {
                        $ip = new Ips();
                        $ip->setDireccion($data->ip);
                        $this->ipsRepository->persist($ip);
                    }
                    $conexion = new Conexiones();
                    $conexion->setIdIp($ip);
                    $conexion->setInicio(new DateTime());
                    $this->conexionesRepository->persist($conexion);
                    $usuario->addConexion($conexion);
                }
                if (isset($data->conectado) && !empty($data->conectado)) {
                    $conectado = new DateTime($data->conectado);
                    $usuario->setAlta($conectado);
                }
                $this->usuarioRepository->save($usuario, true);
                if ($this->usuarioRepository->testUpdate($usuario)) {
                    return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Insertado correctamente', 'status' => '201'], Response::HTTP_CREATED);
                } else {
                    return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Error en la inserción', 'status' => '500'], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            } catch (Exception $e) {
                $msg = 'Error del servidor: ' . $e->getMessage();
                return new JsonResponse(['status' => $msg], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else if ($method === 'DELETE') {
            $rol = $this->rolesRepository->findOneBy(['nombre' => 'bloqueado']);
            $usuario->setRol($rol);
            $this->usuarioRepository->save($usuario, true);
            if($this->usuarioRepository->testDelete($usuario)){
                return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'Usuario bloqueado', 'status' => '201'], Response::HTTP_CREATED);
            }else{
                return new JsonResponse(['date' => date("d-m-y H:i:s"), 'msg' => 'El usuario no se ha podido bloquear', 'status' => '500'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}

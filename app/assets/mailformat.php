<?php

class Mailformat
{

  public function printMailFormatNotification($name)
  {

        $body = "<html>                                                 
                                <body>
                                <table width='100%'>
                                  <div style='background: url(https://i.ibb.co/bNb5CXs/fondo-Correo.png); '>
                                    <div style='text-align:center; '>
                                     
                                      <div style='text-align: center;'>
                                        <h1
                                          style='
                                            color: black;
                                            font-style: normal;
                                            font-weight: 700;
                                            font-size: 18px;
                                            margin-bottom: 30px;
                                          '
                                        >
                                          Estimado cliente
                                        </h1>
                                      </div>";

        $body .= "
    
                                
                              <div style='text-align: center;'>
                              <p
                                  style='
                                    font-style: normal;
                                    font-weight: 400;
                                    font-size: 14px;
                                    color: black;
                                    margin-bottom: 35px;
                                    text-align: center;
                      
                                  '
                                >
                                Hola $name, se cambió la contraseña de tu cuenta. Si no fuiste tú, comunicarse con soporte técnico.     
                                                 </p>
                              </div>
                                                       
                              </div>
                      
                                
                                ";

        $body .= "
                                
                              
                                    <div style='text-align: center; margin-bottom: 30px;'>
    
                                     <footer style='background: transparent; text-align: center; margin-top:35px;
                                     border-top: 2px solid #987C6E;'>
                                        <h1
                                        style='
                                            font-style: normal;
                                            font-weight: 500;
                                            font-size: 14px;
                                            line-height: 21px;
                                            letter-spacing: 0.2em;
                                            text-transform: uppercase;
    
                                            color: black;
                                        '
                                        >CLIENT MANAGEMENT
                                        </h1>
                                    </footer>
                                    </div>
                                    <div style='text-align: center; margin-bottom: 30px;'>
    
                                    <footer style='background: transparent; text-align: center; margin-top:35px'>
                                    <h1
                                    style='
                                        font-style: normal;
                                        font-weight: 500;
                                        font-size: 14px;
                                        line-height: 21px;
                                        letter-spacing: 0.2em;
                                        text-transform: uppercase;
    
                                        color: transparent;
                                    '
                                    >CLIENT MANAGEMENT
                                    </h1>
                                </footer>
                                    </div>
                                </div>
                                </div>
                                </table>
                            </body>
                            </html>
                                ";

        return $body;
    
  }

  public function printMailFormatCode($code, $name)
  {

   

        $body = "<html>                                                 
                <body>
                <table width='100%'>
                  <div style='background: url(https://i.ibb.co/bNb5CXs/fondo-Correo.png); '>
                    <div style='text-align:center; '>
                     
                      <div style='text-align: center;'>
                        <h1
                          style='
                            color: black;
                            font-style: normal;
                            font-weight: 700;
                            font-size: 18px;
                            margin-bottom: 30px;
                          '
                        >
                          Estimado cliente
                        </h1>
                      </div>";

        $body .= "

                
              <div style='text-align: center;'>
              <p
                  style='
                    font-style: normal;
                    font-weight: 400;
                    font-size: 14px;
                    color: black;
                    margin-bottom: 35px;
                    text-align: center;
      
                  '
                ><span>
                Hola $name,
                </span><br>
    
                Hemos enviado este correo para que restaures tu contraseña, tu código de seguridad es           
                                 </p>
              </div>
                                       
              </div>
      
              <div style='text-align: center;'>

                <p
                style='
                  font-style: normal;
                  font-weight: 700;
                  font-size: 22px;
                  color: black;
                  margin-bottom: 35px;
                  text-align: center;
    
                '
              >
  
              $code
              </p>
                
              </div>

              <div style='text-align: center;'>

                <p
                style='
                  font-style: normal;
                  font-weight: 400;
                  font-size: 14px;
                  color: black;
                  margin-bottom: 35px;
                  text-align: center;
    
                '
  
              Si tú no haz solicitado esta acción, ignora este mensaje.
                                        </p>
                
              </div>
                
                ";

        $body .= "
                
              
                    <div style='text-align: center; margin-bottom: 30px;'>

                     <footer style='background: transparent; text-align: center; margin-top:35px;
                     border-top: 2px solid #987C6E;'>
                        <h1
                        style='
                            font-style: normal;
                            font-weight: 500;
                            font-size: 14px;
                            line-height: 21px;
                            letter-spacing: 0.2em;
                            text-transform: uppercase;

                            color: black;
                        '
                        >CLIENT MANAGEMENT
                        </h1>
                    </footer>
                    </div>
                    <div style='text-align: center; margin-bottom: 30px;'>

                    <footer style='background: transparent; text-align: center; margin-top:35px'>
                    <h1
                    style='
                        font-style: normal;
                        font-weight: 500;
                        font-size: 14px;
                        line-height: 21px;
                        letter-spacing: 0.2em;
                        text-transform: uppercase;

                        color: transparent;
                    '
                    >CLIENT MANAGEMENT
                    </h1>
                </footer>
                    </div>
                </div>
                </div>
                </table>
            </body>
            </html>
                ";

                return $body;
  }
}

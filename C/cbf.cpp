
#include <iostream>
#include <fstream>		
#include <string>		// for argv[2] turn to string

using namespace std;

#include "cbf.h"		// main Compressed Bmp File class program

//--------------------------------------------------------------------------------------------
// you should include 
// iostream.h , fstream.h , cmath.h , string.h and cbf.h header files first
//
// read 24-bits BMP file and compress file or extract file and write 24-bits BMP file
// you should pass in 3 parameter for example:
// 
// compress file as C:\>final in.bmp -c out.cbf
//                            in.bmp => what BMP file you want to load in
//                                -c => compress parameter
//                           out.cbf => what compressed filename you want to save
//
// extract compressed file as C:\>final out.cbf -e out.bmp 
//									    out.cbf => what compressed file you want to load in
//										     -e => extract parameter
//										out.bmp => what BMP`s filename you want to save 
// programmer:lenbo chen
// update:01JAN,04
//--------------------------------------------------------------------------------------------

// setup compress quality
// 0:best quality, 128:bad quality
#define quality 2

int main(int argc, char *argv[])
{
	
	CBF compress;
	string parameter = argv[2];
	
	// compress function
	if(parameter == "-c"){
		
		// load BMP file
		compress.InBMP(argv[1]);
		int width = compress.read('w');
		int height = compress.read('h');
		int size = width * height;

		// get BMP class` PixelPtr pointer
		char *PixelPtr = compress.Read_Pixel();

		// set CBF class CBFDataPtr`s room to save data
		compress.Write_CBFData(new char[size*4]);

		// get CBF class CBFDataPtr pointer
		char *CBFDataPtr = compress.Read_CBFData();

		int BmpR, BmpG, BmpB, CbfR, CbfG, CbfB, CbfO;
		int count, CBFDataSize = 0;
		int tmpR, tmpG, tmpB;
		char avgR, avgG, avgB, offset = 1;

		// initial compress program`s parameter
		CbfR = BmpR = 0;
		CbfG = BmpG = 1;
		CbfB = BmpB = 2;
		CbfO = 3;
		for(count = 0; count < size;){
			
			// initial first pixel
			if(offset == 1){
				avgR = PixelPtr[BmpR];
				avgG = PixelPtr[BmpG];
				avgB = PixelPtr[BmpB];
			}

			// calculate the absolute difference value between 2 pixels
			tmpR = avgR - PixelPtr[BmpR+3];
			tmpG = avgG - PixelPtr[BmpG+3];
			tmpB = avgB - PixelPtr[BmpB+3];
			if(tmpR < 0) tmpR = -tmpR;
			if(tmpG < 0) tmpG = -tmpG;
			if(tmpB < 0) tmpB = -tmpB;
	
			// if 2 pixels` absolute difference value <= quality
			// than calculate the average value and will compare next pixel
			if((tmpR <= quality) && (tmpG <= quality) && (tmpB <= quality)){
				avgR = (avgR + PixelPtr[BmpR+3]) / 2;
				avgG = (avgG + PixelPtr[BmpG+3]) / 2;
				avgB = (avgB + PixelPtr[BmpB+3]) / 2;
				BmpR += 3;
				BmpG += 3;
				BmpB += 3;
				
				// if offset overflow the char`s size, force to save data
				if(offset > 126){
					CBFDataPtr[CbfR] = avgR;
					CBFDataPtr[CbfG] = avgG;
					CBFDataPtr[CbfB] = avgB;
					CBFDataPtr[CbfO] = offset;
					// counter pixels` number
					count += offset;
					// pointer to the next room
					CbfR += 4;
					CbfG += 4;
					CbfB += 4;
					CbfO += 4;
					// CBFData`s word + 1
					CBFDataSize += 4;
					// initial offset
					offset = 1;
					}else{
					offset++;
				}

			// if the 2 pixels` absolute difference value > quality
			// than save the current average pixel`s value into CBFDataPtr
			// and next pixel will be compare the next
			}else{
				CBFDataPtr[CbfR] = avgR;
				CBFDataPtr[CbfG] = avgG;
				CBFDataPtr[CbfB] = avgB;
				CBFDataPtr[CbfO] = offset;
				// counter pixels` number
				count += offset;
				// pointer to the next room
				CbfR += 4;
				CbfG += 4;
				CbfB += 4;
				CbfO += 4;
				// CBFData`s word + 1
				CBFDataSize += 4;
				// initial BMP pixel`s value
				BmpR += 3;
				BmpG += 3;
				BmpB += 3;
				// initial offset
				offset = 1;
			}
		}

		// save compressed file
		compress.write('c', CBFDataSize);
		compress.Write_CBFCheck(0, 'C');
		compress.Write_CBFCheck(1, 'B');
		compress.Write_CBFCheck(2, '0');
		compress.Write_CBFCheck(3, '1');
		compress.OutCBF(argv[3]);
	}
	


	// extract function
	if(parameter == "-e"){

		// load CBF file
		compress.InCBF(argv[1]);
		int width = compress.read('w');
		int height = compress.read('h');
		int size = width * height;
		int BmpR, BmpG, BmpB, CbfR, CbfG, CbfB, CbfO, count1, count2;
		char offset;

		// get CBF class` CBFDataPtr pointer
		char *CBFDataPtr = compress.Read_CBFData();

		// set BMP class` PixelPtr`s room to save data
		compress.Write_Pixel(new char[size*3]);

		// get BMP class` PixelPtr pointer
		char *PixelPtr = compress.Read_Pixel();
		
		// initial extract program`s parameter
		CbfR = BmpR = 0;
		CbfG = BmpG = 1;
		CbfB = BmpB = 2;
		CbfO = 3;
		for(count1 = 0; count1 < size; count1++){
			PixelPtr[BmpR] = CBFDataPtr[CbfR];
			PixelPtr[BmpG] = CBFDataPtr[CbfG];
			PixelPtr[BmpB] = CBFDataPtr[CbfB];
			offset = CBFDataPtr[CbfO];
			BmpR += 3;
			BmpG += 3;
			BmpB += 3;
			// repeat offset from 1 to offset
			for(count2 = 1; count2 < offset; count2++){
				PixelPtr[BmpR] = CBFDataPtr[CbfR];
				PixelPtr[BmpG] = CBFDataPtr[CbfG];
				PixelPtr[BmpB] = CBFDataPtr[CbfB];
				BmpR += 3;
				BmpG += 3;
				BmpB += 3;
				count1++;
			}
			CbfR += 4;
			CbfG += 4;
			CbfB += 4;
			CbfO += 4;
		}
		// save BMP file
		compress.OutBMP(argv[3]);
	}	
	
	return 0;
}